# Langkah Perbaikan Pascainsiden Keamanan

## Kesimpulan utama

Ini adalah kompromi nyata, bukan sekadar aktivitas scanner. Kemampuan mengubah `public/index.php`, `.htaccess`, dan menaruh `.php7` berarti pihak luar sudah memperoleh akses tulis ke document root.

Namun, [log-serangan.md](log-serangan/log-serangan.md#L252) belum cukup untuk menentukan pintu masuk:

- Dari 343 request, 240 berakhir `404` dan hanya ada 5 `POST`.
- Tidak ada request ke endpoint Livewire/upload atau akses berhasil ke file `.php7`.
- Payload traversal dan `pearcmd` mendapat `200`, tetapi ukuran responsnya hampir sama dengan halaman utama—kemungkinan hanya fallback Laravel, bukan bukti command berhasil.
- Perubahan ukuran homepage dari sekitar 182 KB menjadi sekitar 28 KB lalu 0 byte menunjukkan keadaan situs berubah, tetapi tidak mengungkap penyebabnya.

Kemungkinan jalur masuk, dari yang paling perlu diperiksa: kredensial cPanel/FTP/SSH bocor, situs lain dalam akun cPanel yang sama terkompromi, akun Filament diambil alih, lalu celah upload/dependensi aplikasi. Jangan menyimpulkan IP tertentu sebagai pelaku dari log ini.

## Perubahan prioritas di proyek lokal

### 1. Perbarui seluruh dependency sebelum deploy kembali

Lock saat ini berisi Filament 5.4.2 dan Laravel 13.2.0: [composer.lock](../composer.lock#L977) dan [composer.lock](../composer.lock#L2022). `composer audit --locked --no-dev` menemukan **27 advisori produksi pada 14 paket**.

Salah satunya CVE-2026-48500, yaitu upload temporary file tanpa autentikasi pada halaman auth Filament 5.4.2. Versi aman minimal 5.6.5; versi terbaru yang terdeteksi saat audit adalah 5.6.8. Dampak utama CVE ini adalah penyalahgunaan storage, bukan bukti langsung RCE. Lihat [advisori resmi CVE-2026-48500](https://github.com/advisories/GHSA-44wp-g8f4-f4v5).

Jalankan secara lokal, lalu commit `composer.lock`:

```bash
composer update --with-all-dependencies
composer audit --locked --no-dev
php artisan test
npm audit --omit=dev
```

Targetkan audit Composer menjadi nol. Audit npm saat ini sudah nol.

### 2. Hapus `preserveFilenames()` dari empat uploader publik

Lokasinya:

- [DokumenProdukResource.php](../app/Filament/Clusters/SertifikasiProduk/Resources/DokumenProdukResource.php#L42)
- [TarifProdukResource.php](../app/Filament/Clusters/SertifikasiProduk/Resources/TarifProdukResource.php#L44)
- [HakKewajibanProdukResource.php](../app/Filament/Clusters/SertifikasiProduk/Resources/HakKewajibanProdukResource.php#L46)
- [InformasiPublikProdukForm.php](../app/Filament/Clusters/SertifikasiProduk/Resources/InformasiPublikProdukResource/Schemas/InformasiPublikProdukForm.php#L24)

Filament secara eksplisit memperingatkan bahwa `preserveFilenames()` pada disk `local` atau `public` dapat menjadi RCE walaupun `acceptedFileTypes()` digunakan, karena MIME bisa dimanipulasi. Gunakan nama acak dan simpan nama asli ke kolom metadata dengan `storeFileNamesIn()`. Lihat [dokumentasi keamanan upload Filament](https://filamentphp.com/docs/5.x/forms/file-upload#security-implications-of-controlling-file-names).

### 3. Pindahkan dokumen dari disk publik ke disk private

PDF, DOCX, dan ZIP sebaiknya masuk `storage/app/private`, kemudian dilayani melalui controller download yang melakukan otorisasi. Disk publik cukup untuk gambar yang memang harus dapat diakses langsung.

Untuk seluruh 56 field upload yang ditemukan:

- Tetapkan `acceptedFileTypes()` atau `image()` secara eksplisit.
- Tetapkan `maxSize()`—saat ini hanya 16 yang memiliki batas eksplisit.
- Gunakan nama acak.
- Tambahkan `preventFilePathTampering()`.
- Tambahkan test penolakan `.php`, `.php7`, `.phtml`, `.phar`, double extension, dan MIME palsu.

### 4. Wajibkan MFA pada Filament

[AdminPanelProvider.php](../app/Providers/Filament/AdminPanelProvider.php#L32) hanya mengaktifkan login biasa. Tambahkan TOTP MFA dan set `isRequired: true`. Filament sudah menyediakan implementasi resminya. Lihat [dokumentasi MFA Filament](https://filamentphp.com/docs/5.x/users/multi-factor-authentication#requiring-multi-factor-authentication).

### 5. Hilangkan akun test/default admin dari jalur produksi

Seeder membuat `test@example.com` dengan password factory `password`, sementara default role adalah `admin`:

- [DatabaseSeeder.php](../database/seeders/DatabaseSeeder.php#L23)
- [UserFactory.php](../database/factories/UserFactory.php#L31)
- [Migrasi role](../database/migrations/2026_06_07_000000_add_role_to_users_table.php#L15)

Periksa database produksi dan hapus/nonaktifkan akun tersebut. Buat forward migration untuk mengubah default role menjadi non-admin; jangan mengedit migration yang sudah pernah dijalankan. Seeder akun test harus dibatasi hanya untuk environment lokal/testing.

### 6. Cegah eksekusi PHP di direktori upload

[public/.htaccess](../public/.htaccess#L1) saat ini bersih, tetapi belum memblokir `.php7`, `.phtml`, `.phar`, dan keluarga PHP lainnya.

Tambahkan aturan Apache/cPanel agar:

- Hanya `public/index.php` boleh dieksekusi.
- PHP tidak boleh dieksekusi dari `/storage` atau direktori upload mana pun.
- Directory listing dimatikan.
- Tidak ada `AddHandler` yang membuat `.php7` dapat dijalankan.

Sebaiknya aturan utama dipasang pada konfigurasi hosting/vhost oleh provider, bukan hanya `.htaccess` yang dapat ditimpa penyerang.

### 7. Sanitasi rich content sebelum ditampilkan

Beberapa Blade menampilkan isi database dengan `{!! !!}`, misalnya [news/show.blade.php](../resources/views/news/show.blade.php#L36). Gunakan `RichContentRenderer`/`renderRichContent()` agar HTML disanitasi. Ini mencegah stored XSS menjadi mekanisme persistence setelah akun admin diambil alih. Lihat [dokumentasi renderer Filament](https://filamentphp.com/docs/5.x/forms/rich-editor#rendering-rich-content).

## Yang harus dilakukan di cPanel sekarang

Menghapus file berbahaya saja belum cukup. Lakukan sebelum situs dibuka kembali:

- Isolasi situs dan simpan snapshot, hash, access log, error log, ModSecurity log, serta Laravel log untuk forensik.
- Minta provider memeriksa log login cPanel, FTP, SSH, perubahan file, dan kemungkinan kompromi akun lain/shared hosting.
- Redeploy ke akun/server bersih dari source lokal dan `composer.lock` yang sudah diperbarui. Jangan menyalin kembali `vendor`, cache, atau upload lama tanpa pemeriksaan.
- Rotasi dari perangkat yang bersih: password cPanel, email pemulihan, FTP/SFTP/SSH, database, admin Filament, mail/API token, deploy key, dan `APP_KEY`.
- Rotasi `APP_KEY` akan menginvalidasi session/cookie dan data terenkripsi; inventarisasi encrypted fields terlebih dahulu. Setelah itu hapus seluruh session dan `remember_token`.
- Audit cron, FTP accounts, SSH `authorized_keys`, email forwarder, database users, `.user.ini`, `php.ini`, `auto_prepend_file`, semua `.htaccess`, symlink, dan file di temporary directory.
- Aktifkan [2FA cPanel](https://docs.cpanel.net/cpanel/security/two-factor-authentication-for-cpanel/).
- Pastikan document root menunjuk tepat ke folder Laravel `public`; source, `.env`, `vendor`, dan `storage` tidak boleh berada dalam web root. Hanya `storage` dan `bootstrap/cache` yang perlu writable. Ini juga merupakan rekomendasi resmi [deployment Laravel](https://laravel.com/docs/13.x/deployment#server-configuration).
- Produksi wajib memakai `APP_ENV=production`, `APP_DEBUG=false`, HTTPS, secure session cookie, dan idealnya `SESSION_ENCRYPT=true`.
- Aktifkan ModSecurity/OWASP CRS dan batasi akses `/admin` dengan VPN atau allowlist IP bila memungkinkan.

## Kondisi proyek lokal saat audit

- `public/index.php` dan `.htaccess` sesuai dengan versi yang tersimpan di Git.
- Tidak ditemukan executable asing di dalam `public`.
- Output test mencapai **47 test lulus dengan 151 assertion**.
- Pada audit awal tidak ada file proyek yang diubah. Pada tahap dokumentasi ini, hanya laporan `celah-keamanan/langkah-perbaikan.md` yang ditambahkan.

