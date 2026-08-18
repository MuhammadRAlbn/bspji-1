# Panduan Penerapan Menu SPM pada Seluruh Layanan

Dokumen ini ditujukan kepada AI agent yang akan menerapkan fitur SPM Pengujian ke menu pelayanan lain pada aplikasi Laravel/Filament ini.

Gunakan implementasi Pengujian sebagai referensi, tetapi jangan menyalin nama class, tabel, route, variabel, pesan, atau direktori `pengujian/spm` secara mentah.

## 1. Tujuan dan batasan wajib

Untuk setiap layanan, tambahkan submenu admin **SPM**, pengelolaan tepat satu gambar aktif, serta tab/bagian SPM pada halaman publik.

Ketentuan yang tidak boleh dilonggarkan:

- hanya role `admin` yang dapat mengelola resource;
- guest diarahkan ke login dan Humas/non-admin ditolak;
- hanya satu record SPM per layanan;
- input hanya JPEG, PNG, atau WebP;
- maksimum 5 MB dan 4096 ? 4096 piksel;
- output selalu WebP kualitas 82 dengan nama ULID acak dan ekstensi `.webp`;
- file sumber, metadata, nama asli, dan payload tambahan tidak disimpan;
- SVG, GIF, keluarga PHP, MIME palsu, dan manipulasi path ditolak;
- tidak ada judul, deskripsi, galeri, atau riwayat kecuali scope diubah pengguna;
- jangan menaikkan versi dependency tanpa persetujuan.

## 2. Placeholder penamaan

Tentukan ini sebelum menulis kode:

```text
{Layanan}            contoh: Kalibrasi
{LayananPascal}      contoh: Kalibrasi
{layananCamel}       contoh: kalibrasi
{layanan_slug}       contoh: kalibrasi
{ClusterClass}       cluster Filament target
{SpmModel}           contoh: SpmKalibrasi
{spm_table}          contoh: spm_kalibrasis
{PublicController}   controller halaman publik
{PublicView}         Blade halaman publik
{PublicRoute}        route halaman publik
{StorageDirectory}   contoh: kalibrasi/spm
```

Periksa kembali seluruh placeholder. Resource Kalibrasi tidak boleh masih memakai model, policy, pesan, atau direktori Pengujian.

## 3. Referensi yang wajib dibaca

- `app/Actions/Images/ConvertUploadedImageToWebp.php`
- `app/Exceptions/InvalidUploadedImage.php`
- `app/Rules/AuthorizedSpmImageUpload.php`
- `app/Models/SpmPengujian.php`
- `app/Policies/SpmPengujianPolicy.php`
- `app/Filament/Clusters/Pengujian/Resources/SpmPengujianResource.php`
- `app/Filament/Clusters/Pengujian/Resources/SpmPengujianResource/Pages/`
- `database/migrations/2026_07_28_000000_create_spm_pengujians_table.php`
- `app/Http/Controllers/PengujianController.php`
- `resources/views/pengujian.blade.php`
- `tests/Feature/Images/ConvertUploadedImageToWebpTest.php`
- `tests/Feature/Filament/Pengujian/SpmPengujianResourceTest.php`
- `tests/Feature/PengujianPageTest.php`
- `storage/app/public/.htaccess`
- `storage/app/public/.gitignore`

Ikuti pola sibling resource/controller/view/test pada cluster target. Jangan membuat pola Laravel atau Filament kedua bila proyek sudah memiliki cara yang konsisten.

## 4. Audit sebelum implementasi

1. Jalankan `git status --short`; jangan menimpa perubahan pengguna.
2. Temukan cluster, controller, route, Blade, model, dan test layanan target.
3. Periksa urutan tab dan pola kartu/lightbox halaman publik.
4. Gunakan `User::isAdmin()`; jangan membuat cara pemeriksaan role baru.
5. Periksa versi Laravel, Filament, Livewire, dan PHP yang terpasang.
6. Pastikan GD dan WebP tersedia:

   ```bash
   php -r "var_dump(extension_loaded('gd'), function_exists('imagewebp'));"
   ```

7. Pastikan `public/storage` benar dan Apache mengizinkan `.htaccess`.
8. Jangan mengubah migration yang pernah dijalankan; buat migration baru.

## 5. Matriks perubahan

Per layanan biasanya dibuat migration, model, policy, rule anti-path-tampering, Filament Resource beserta List/Create/Edit, test resource, dan test halaman publik.

Biasanya diubah: controller publik, Blade publik, konfigurasi direktori converter, serta asset build bila ada class Tailwind baru.

Hal berikut bersifat global dan hanya dilakukan sekali: `ext-gd` di Composer, `storage/app/public/.htaccess`, serta whitelist `.htaccess` di `.gitignore` storage.

## 6. Database, model, dan singleton

Tabel minimal memiliki `id`, `image_path` wajib, dan timestamps. Migration wajib memiliki `down()` yang reversibel.

Model harus:

- memiliki `$fillable = ['image_path']`;
- hanya menganggap `{layanan_slug}/spm/{ULID}.webp` sebagai managed path;
- menghapus file lama setelah perubahan record berhasil disimpan;
- menghapus file aktif setelah record berhasil dihapus;
- tidak menghapus path di luar managed directory.

Contoh pola managed path:

```php
preg_match(
    '/\A{layanan_slug}\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
    $path,
) === 1;
```

Jangan menghapus file lama sebelum save database berhasil. Policy dan `Resource::canCreate()` mencegah duplikasi normal. Jika dua request admin dapat berjalan bersamaan, tambahkan jaminan atomik berupa unique singleton key atau lock server-side; `exists()` saja tidak menjamin singleton saat race condition.

## 7. Policy dan otorisasi

Policy wajib mendefinisikan `viewAny`, `view`, `create`, `update`, `delete`, dan `deleteAny`. Semuanya hanya mengizinkan `$user->isAdmin()`.

`create` juga memastikan record belum ada. Ulangi guard melalui `Resource::canCreate()` agar tombol Create hilang setelah singleton tersedia. Menyembunyikan menu bukan pengganti policy karena URL dapat dipanggil langsung.

## 8. Konverter WebP aman

Gunakan satu inti converter yang dapat diaudit; jangan menggandakan algoritme per layanan. Direktori harus berasal dari constant, enum, atau allowlist server-side, bukan request, state Livewire, query string, nama file, atau form.

Alur wajib:

1. Pastikan GD dan `imagewebp()` tersedia.
2. Pastikan real path temporary upload ada.
3. Validasi ekstensi asli hanya `jpg`, `jpeg`, `png`, atau `webp`.
4. Tolak segmen `php`, `phpN`, `phtml`, `phar`, dan `phps` di nama asli.
5. Validasi ukuran aktual maksimum 5 MB.
6. Gunakan `finfo(FILEINFO_MIME_TYPE)` untuk MIME aktual.
7. Gunakan `getimagesize()` untuk signature, tipe, dan dimensi.
8. Pastikan MIME `finfo`, MIME gambar, dan `IMAGETYPE_*` konsisten.
9. Decode hanya dengan decoder JPEG, PNG, atau WebP yang sesuai.
10. Normalisasi orientasi EXIF JPEG, true color, dan alpha.
11. Re-encode dengan `imagewebp(..., 82)`.
12. Verifikasi header RIFF/WEBP.
13. Simpan sebagai `Str::ulid().'.webp'` ke `{StorageDirectory}`.
14. Verifikasi MIME hasil tersimpan adalah `image/webp`.
15. Bila tahap mana pun gagal, hapus file parsial dan jangan buat/ubah record.

Polyglot boleh diproses bila gambar dasarnya valid, tetapi payload tambahan harus hilang melalui re-encoding.

Untuk converter reusable, validasi direktori terhadap allowlist. Tolak path absolut, `..`, backslash, null byte, dan direktori di luar daftar. Resource hanya boleh mengirim constant source code.

## 9. Anti-path-tampering Filament/Livewire

State FileUpload hanya boleh berupa:

- `TemporaryUploadedFile` baru; atau
- string yang sama persis dengan raw original `image_path` record saat edit.

Gunakan `nestedRecursiveRule()` karena rule FileUpload biasa dapat hanya memvalidasi temporary upload dan melewatkan string state yang dimanipulasi. Bandingkan dengan `hash_equals()` dan baca nilai lama melalui `$record?->getRawOriginal('image_path')`.

Jangan menerima arbitrary existing path atau path record lain. Jangan memakai `deleteUploadedFileUsing()` untuk replacement karena file lama dapat terhapus sebelum save database sukses.

## 10. Filament Resource

Resource harus memiliki:

- cluster target, slug `spm`, label `SPM`, dan icon konsisten;
- FileUpload required;
- MIME JPEG/PNG/WebP, rules image/extensions/MIME/dimensions;
- `maxSize(5120)` dan `maxParallelUploads(1)`;
- disk `public` dan direktori server-side;
- custom `saveUploadedFileUsing()` yang memanggil converter;
- exception converter dipetakan ke `ValidationException` pada state path;
- ImageColumn, EditAction, DeleteAction, tanpa pagination;
- halaman List, Create, Edit;
- `canCreate()` menolak record kedua.

Verifikasi URL melalui `php artisan route:list`. Pola umumnya:

```text
/admin/{layanan_slug}/spm
/admin/{layanan_slug}/spm/create
/admin/{layanan_slug}/spm/{record}/edit
```

## 11. Halaman publik

Query record di controller, bukan Blade, lalu kirim ke view. Pada Blade:

- tambahkan tab SPM pada posisi yang diminta;
- ikuti responsivitas, spacing, transisi, kartu, dan lightbox sibling;
- tampilkan gambar `object-contain` dengan alt text spesifik;
- sediakan placeholder saat record/path kosong;
- gunakan `asset('storage/'.$path)` hanya untuk managed path;
- serialisasikan URL ke Alpine/JavaScript dengan `@js(...)`;
- jangan query database atau menampilkan nama file asli.

Bila kartu/lightbox berulang pada banyak layanan, ekstrak menjadi Blade component dengan props eksplisit dan `$attributes->merge()`.

## 12. Hardening storage global

Pertahankan `storage/app/public/.htaccess`:

```apache
Options -Indexes -ExecCGI

<FilesMatch "(?i)\.(php[0-9]*|phtml|phar|phps)$">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>

    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
    </IfModule>
</FilesMatch>
```

`storage/app/public/.gitignore` harus mengizinkan `.gitignore` dan `.htaccess`. Untuk Nginx atau object storage, buat aturan ekuivalen karena `.htaccess` hanya berlaku pada Apache.

## 13. Test wajib

Jangan menghapus security/regression tests setelah fitur selesai.

Converter harus menguji format valid menjadi WebP nyata bernama acak; SVG/GIF, keluarga PHP, double extension, MIME palsu, file teks, oversize, dan over-dimension ditolak; payload polyglot hilang; kegagalan decoder/encoder/storage tidak meninggalkan file.

Resource harus menguji guest redirect, admin berhasil, Humas/non-admin 403, singleton, path tampering, raw original saat edit, cleanup replacement/delete, kegagalan save tidak merusak file lama, dan path di luar managed directory tidak dihapus.

Publik harus menguji tab SPM, placeholder, URL storage, alt/lightbox, dan placeholder hilang saat gambar tersedia.

Test scaffold seperti `assertTrue(true)` boleh dihapus, tetapi test keamanan SPM wajib masuk Git.

## 14. Verifikasi dan deployment

Jalankan:

```bash
php artisan test --compact --filter=NamaTestSpm
php artisan test --compact
vendor/bin/pint --test --dirty
composer validate --strict
npm run build
php artisan route:list
```

Lakukan browser QA pada resource admin dan halaman publik. Periksa tab, placeholder, gambar, lightbox, mobile, dan console error.

Untuk Apache, jalankan `httpd -t`, lalu akses sentinel tidak berbahaya berekstensi `.php7` di public storage. Hasil harus 403/404 dan tidak pernah dieksekusi. Hapus sentinel setelah pemeriksaan.

Sebelum production: backup database/storage; pastikan GD tersedia pada PHP web dan CLI; pastikan storage link/permission benar; deploy source dan asset build yang sama; gunakan lock file; audit migration pending; lalu ulangi upload, replacement, delete, publik, dan smoke test storage.

Jangan menjalankan semua migration pending secara buta bila ada migration lama di luar release.

## 15. Risiko Filament

Saat panduan dibuat, repository memakai Filament 5.4.2 dan masih terdampak kerentanan upload sementara tanpa autentikasi yang diperbaiki mulai 5.6.5.

Hardening ini mengamankan pipeline file akhir, tetapi tidak membuat seluruh panel aman dari kerentanan tersebut. Upgrade Filament harus menjadi pekerjaan terpisah sebelum panel dinyatakan aman penuh.

- https://github.com/advisories/GHSA-44wp-g8f4-f4v5
- https://filamentphp.com/docs/5.x/forms/file-upload

## 16. Definition of Done

Layanan selesai hanya bila submenu/URL benar; policy admin-only dan singleton bekerja; input valid menjadi WebP sanitasi; input berbahaya dan path tampering ditolak; cleanup aman; tab publik, placeholder, gambar, dan lightbox bekerja; tidak ada file/nama asli disimpan; targeted test dan full suite lulus; Pint, Composer validate, build, route, browser QA, dan web-server smoke test selesai; serta migration, GD, deployment, dan risiko Filament sudah dicatat.

## 17. Larangan bagi AI agent

- Jangan mempercayai MIME, nama, ekstensi, atau path client.
- Jangan menyimpan sumber atau memakai nama pengguna sebagai output.
- Jangan menerima arbitrary storage path, SVG, atau GIF.
- Jangan query database di Blade.
- Jangan hapus file lama sebelum save baru berhasil.
- Jangan hapus file tanpa validasi managed path.
- Jangan edit migration yang sudah dijalankan.
- Jangan menjalankan destructive Git command atau menimpa perubahan pengguna.
- Jangan menghapus test keamanan untuk membuat suite terlihat lulus.
- Jangan upgrade dependency di luar scope.
- Jangan menyatakan sistem sepenuhnya aman selama risiko Filament belum diperbaiki.
