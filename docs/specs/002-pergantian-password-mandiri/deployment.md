# Aktivasi dan Penggunaan Ubah Password

Tanggal: 3 Oktober 2026. Implementasi tersedia dalam working tree; hasil regresi penuh dicatat pada [verification.md](verification.md).

## 1. Aktivasi

Spec 002 tidak menambah migration, paket, role, atau akun bawaan. Dua migration spec 001 tetap merupakan prasyarat Manajemen Akun. Password dan status akun operasional tidak diubah oleh pekerjaan pengujian ini.

Pada deployment normal, terapkan perubahan kode beserta proses cache aplikasi yang digunakan proyek. Bila deployment memakai route/config cache, bangun kembali cache tersebut agar route profil dan middleware baru terdaftar. Pastikan cache rate limiter tersedia dan digunakan bersama oleh worker/instance aplikasi; cache array hanya untuk test/preview. Produksi mengikuti konfigurasi HTTPS aplikasi.

Sesi yang dibuat sebelum fitur ini dan belum membawa fingerprint HMAC harus login ulang. Ini bukan kewajiban mengganti password: password existing masih berlaku. Cookie Ingat Saya yang masih sah dapat membentuk sesi baru setelah verifikasi token dan fingerprint. Setelah password diganti atau direset, cookie lama tidak berlaku.

Konfigurasi aplikasi yang ditinjau memakai sesi database. Cleanup memakai `session.connection` dan `session.table`, serta broker reset password aplikasi. Test otomatis mencakup driver array/database, preview UI driver file. Redis dan transaksi MySQL paralel belum diuji; bila mengganti driver/connection, verifikasi ulang revokasi dalam lingkungan uji terpisah. Atomic rollback yang diuji memakai tabel akun/token/sesi pada koneksi database yang sama.

## 2. Pengguna mengganti password sendiri

1. Login seperti biasa dengan akun Admin, Humas, FAP, atau Kepala Balai yang aktif.
2. Klik avatar/menu akun di kanan atas, lalu **Ubah Password**. URL langsung: `/admin/ubah-password`.
3. Isi **Password Saat Ini**, **Password Baru**, dan **Konfirmasi Password Baru**.
4. Password baru minimal 12 karakter, berbeda dari yang berlaku, dan konfirmasinya harus sama persis. Spasi boleh dipakai. Untuk bcrypt, batasnya 72 byte; karakter multibyte dapat memakai lebih dari satu byte.
5. Klik **Simpan Password**. Setelah sukses, muncul notifikasi, input kosong, dan sesi saat ini tetap login dengan ID baru. Perangkat lain perlu login lagi.
6. **Kembali** menuju Pengaduan untuk FAP/Kepala Balai, atau dashboard untuk Admin/Humas.

Penggantian bersifat opsional. Pengguna tetap dapat memakai fitur sesuai role dengan password awal yang masih berlaku. Batas percobaan ialah 5 per menit per akun dan 20 per menit per IP; pesan memberi waktu untuk mencoba kembali. Pembatasan tidak menonaktifkan akun.

## 3. Admin membantu akun lain

Admin menetapkan password awal saat Buat Akun. Untuk pengguna yang lupa password, buka **Administrasi > Manajemen Akun > Ubah**, isi password baru dan konfirmasi, lalu simpan. Reset tidak memerlukan password lama target, tetapi mencabut seluruh sesi, remember token lama, dan reset token target. Pengguna dapat memakai password hasil reset atau menggantinya sendiri kapan saja.

Password kosong saat edit mempertahankan password/token/sesi target. Pada record admin sendiri, field reset tidak tersedia: tautan **Ubah Password** membuka alur dengan verifikasi password saat ini. Edit nama/email sendiri tetap tersedia. Tidak ada fitur lupa password lewat email pada tahap ini.

## 4. Verifikasi ulang

```powershell
php artisan test --compact --filter=PasswordManagementTest
php artisan test --compact
```

Test memakai SQLite in-memory dari `phpunit.xml`. Akun dummy hanya dibuat pada database test atau preview terpisah. Bila sandbox Windows membuat `is_readable`/`is_writable` PHP salah mendeteksi ACL, jalankan test/formatter melalui proses PHP yang memiliki akses workspace normal; tidak perlu mengubah permission file atau konfigurasi database operasional.
