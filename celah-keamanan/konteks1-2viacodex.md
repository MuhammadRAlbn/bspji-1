# Roadmap Pemulihan dan Hardening Pascakompromi

## Kesimpulan

- Insiden harus diklasifikasikan sebagai **kompromi terkonfirmasi**, karena terdapat file PHP asing serta perubahan tidak sah pada `public/index.php` dan `.htaccess`.
- **Vektor masuk belum terkonfirmasi.** Respons HTTP `200` pada payload `pearcmd` atau `echo` tidak membuktikan RCE. Kemungkinan yang harus diuji mencakup kredensial cPanel/FTP/admin bocor, upload berbahaya, dependensi rentan, konfigurasi PHP, dan kompromi akun hosting.
- Repo lokal saat ini tidak menunjukkan perubahan pada `public/index.php`/`.htaccess` atau file PHP asing di upload. Namun, repo memakai Laravel `13.2.0` dan Filament `5.4.2` dengan advisory aktif.
- Semua 56 field upload memiliki pembatasan tipe, tetapi empat upload dokumen menggunakan `preserveFilenames()` pada disk publik. Filament memperingatkan kombinasi ini dapat memungkinkan RCE meskipun MIME dibatasi; nama acak harus dipakai. [Filament file-upload security](https://filamentphp.com/docs/5.x/forms/file-upload)
- Filament `5.4.2` juga termasuk versi terdampak upload sementara tanpa autentikasi; versi perbaikannya minimal `5.6.5`. [Filament advisory](https://github.com/advisories/GHSA-44wp-g8f4-f4v5)
- Laravel harus dinaikkan minimal ke `13.12.0` untuk menutup signed-URL path confusion dan sekaligus melewati perbaikan CRLF pada `13.10.0`. [Signed URL advisory](https://github.com/advisories/GHSA-crmm-hgp2-wgrp), [CRLF advisory](https://github.com/advisories/GHSA-5vg9-5847-vvmq)

## Roadmap Pelaksanaan

### P0 — Containment dan preservasi bukti, sekarang–4 jam

- Pertahankan situs offline. Jangan arahkan kembali Document Root ke folder lama dan jangan menghapus folder `overload`.
- Dari perangkat bersih, rotasi berurutan: email pemilik cPanel, cPanel, FTP/SFTP, database, SMTP/API, seluruh akun admin aplikasi, kemudian cabut semua sesi aktif dan aktifkan 2FA.
- Buat tiket insiden prioritas tinggi kepada penyedia hosting untuk:
  - mengambil snapshot akun sebelum perubahan lanjutan;
  - menyimpan access/error log, ModSecurity audit log, riwayat login cPanel/FTP, cron, akun, proses, dan timestamp filesystem;
  - memindai seluruh akun, bukan hanya folder Laravel;
  - memeriksa mapping handler `.php7`, `register_argc_argv`, proses persisten, dan potensi kompromi lintas akun.
- Unduh arsip read-only folder terinfeksi, database, konfigurasi Apache/PHP, cron, daftar akun, dan log yang tersedia melalui cPanel.
- Jangan membuka atau mengeksekusi file PHP mencurigakan pada komputer utama.

### P1 — Investigasi dan penentuan restore point, 4–24 jam

- Susun timeline dari perubahan pertama `index.php`, `.htaccess`, webshell, login panel, dan request berbahaya; pilih backup sebelum indikator kompromi paling awal.
- Audit seluruh akun untuk PHP-family files, cron asing, akun/FTP baru, `.user.ini`, `php.ini`, subdomain, redirect, mail forwarder, database user, dan perubahan Document Root.
- Bandingkan source produksi dengan Git, tetapi jangan menganggap file yang tidak terlacak Git otomatis aman.
- Tentukan akar masalah hanya jika didukung artefak. Jika bukti tidak cukup, dokumentasikan sebagai “unknown initial access” dan tetap tutup seluruh kandidat vektor.

### P2 — Clean rebuild dan hardening, 1–3 hari

- Bangun release baru di direktori kosong dari Git tepercaya; jangan menyalin `vendor`, cache, `.env`, `index.php`, `.htaccess`, atau kode dari folder terinfeksi.
- Pulihkan database dan upload dari backup pra-insiden. Pindai file, terapkan whitelist ekstensi/MIME, dan jangan memigrasikan file executable.
- Jalankan update kompatibel penuh dan kunci minimal:
  - Laravel `>=13.12.0`;
  - Filament `>=5.6.5`;
  - seluruh Symfony/Guzzle/transitive dependency ke versi patched;
  - `composer audit` harus menghasilkan nol advisory sebelum rilis.
- Perbaiki upload:
  - hapus empat `preserveFilenames()` dan gunakan nama acak Laravel/Livewire;
  - gambar publik tetap bernama acak;
  - PDF/DOCX/ZIP dipindahkan ke disk private dan dilayani melalui controller download;
  - blokir `.php`, `.php7`, `.phtml`, `.phar`, `.phps`, dan keluarga PHP lain pada `/storage` serta seluruh direktori upload;
  - aktifkan perlindungan path tampering Filament setelah upgrade.
- Hardening aplikasi:
  - aktifkan MFA admin, rate limit login, session cookie `Secure`/`HttpOnly`, enkripsi session, dan invalidasi session lama;
  - tambahkan `TrustHosts` untuk domain resmi;
  - tambahkan throttle pada dua endpoint API publik dan hilangkan detail exception dari respons;
  - pastikan `APP_ENV=production`, `APP_DEBUG=false`, serta buat `.env` baru dengan seluruh rahasia yang sudah dirotasi;
  - rotasi `APP_KEY` setelah backup final; repo tidak menunjukkan penggunaan encrypted cast/Crypt, tetapi seluruh session tetap harus dianggap gugur.
- Hardening cPanel/Apache:
  - Document Root wajib menuju direktori release `public`, sesuai panduan deployment Laravel. [Laravel deployment](https://laravel.com/docs/13.x/deployment)
  - hanya `storage` dan `bootstrap/cache` yang writable; kode dan `public` tidak writable oleh proses aplikasi jika hosting mendukung pemisahan ownership;
  - hapus handler `.php7`, matikan `register_argc_argv` untuk web SAPI bila aplikasi tidak memerlukannya;
  - aktifkan ModSecurity/OWASP CRS, cPHulk, AutoSSL, 2FA, dan pembatasan IP/VPN panel bila memungkinkan;
  - terapkan CSP dalam mode report-only sebelum enforcement dan aktifkan HSTS setelah seluruh HTTPS/subdomain diverifikasi.

### P3 — Staging, cutover, dan monitoring, 3–7 hari

- Uji release baru pada staging/subdomain yang dibatasi IP dengan salinan database.
- Setelah seluruh acceptance gate lulus, ubah Document Root ke release baru; jangan mengganti nama folder lama kembali.
- Monitor ketat selama 48 jam: perubahan file, login, respons `403/404/500`, upload, kapasitas disk, cron, dan outbound mail.
- Simpan folder lama sebagai barang bukti minimal 30–90 hari atau sesuai kebijakan instansi; hapus hanya setelah investigasi dan retensi selesai.
- Terapkan deployment berbasis release dari Git, checksum file inti, backup offsite, log offsite, serta `composer audit` otomatis pada setiap build dan secara berkala.

## Perubahan Interface

- `/api/nps/store` dan `/api/penilaian-petugas/store` mempertahankan payload sukses, tetapi request berlebihan menghasilkan `429` dan error internal tidak lagi membocorkan pesan exception.
- Path file upload berubah menjadi nama acak; nama dokumen untuk pengguna tetap berasal dari kolom judul/nama yang sudah tersedia.
- Dokumen non-gambar dilayani melalui route download, bukan URL storage langsung.
- Login admin memperoleh langkah MFA dan seluruh sesi lama dinonaktifkan.

## Test dan Acceptance Gate

- Upload `.php`, `.php7`, `.phtml`, `.phar`, file MIME palsu, double extension, dan polyglot jinak harus ditolak di seluruh upload surface.
- Request tanpa autentikasi ke upload sementara Filament harus ditolak dan tidak menghasilkan file persisten.
- `/storage/test.php7`, `/.env`, `/.git`, dan Host header asing harus menghasilkan `403/404`, tidak pernah mengeksekusi atau membocorkan konten.
- Login diuji untuk throttle, MFA, session invalidation, dan authorization per role.
- API publik diuji untuk validasi, rate limit, respons error generik, dan tidak menulis data setelah batas tercapai.
- Seluruh feature test, route test, upload/download test, dan smoke test halaman publik/admin harus lulus.
- `composer audit` harus nol advisory; scan release tidak boleh menemukan executable asing di `public` atau storage.
- Situs hanya boleh diaktifkan kembali setelah hosting mengonfirmasi pemeriksaan seluruh akun dan tidak ada persistensi aktif.

## Asumsi

- Produksi menggunakan cPanel/Apache, akses saat ini hanya melalui cPanel, dan situs offline karena folder root diganti nama.
- Git serta backup pra-insiden tersedia dan menjadi satu-satunya sumber pemulihan tepercaya.
- Kredensial belum dirotasi, sehingga rotasi dan pencabutan sesi merupakan tindakan pertama.
- Pemulihan dilakukan sebagai clean rebuild; pembersihan in-place pada folder lama tidak digunakan.
