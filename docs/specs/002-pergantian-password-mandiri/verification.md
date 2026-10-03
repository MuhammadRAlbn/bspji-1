# Verifikasi Pergantian Password Mandiri

Tanggal: 3 Oktober 2026 (Asia/Jakarta). Status: implementasi dan suite proyek selesai diverifikasi; 261 test lulus (1.997 assertion).

## 1. Pengujian otomatis

`tests/Feature/Filament/PasswordManagementTest.php` memuat 37 skenario/case data provider, seluruhnya termasuk dalam suite proyek yang lulus. Putaran fokus sebelum tambahan kasus: 34 lulus (356 assertion). Setelah perbaikan setup, dua test tambahan rollback/endpoint Livewire lulus (10 assertion). Hasil final setelah seluruh perubahan: **261 test lulus (1.997 assertion), tanpa kegagalan**, durasi **405,61 detik**. Pint dijalankan pada file PHP baru dan perubahan; `git diff --check` juga lulus.

Test ditulis sebelum implementasi. Eksekusi awal terhalang `is_readable` bootstrap PHPUnit di sandbox Windows, sehingga tidak diklaim sebagai test merah terverifikasi. Eksekusi sesudahnya dan Pint memakai proses PHP dengan akses workspace normal. Test tetap memakai SQLite in-memory, sesi/cache test, dan tidak mengubah akun operasional.

| Persyaratan | Bukti otomatis |
| --- | --- |
| FR-01/FR-04, AC-01/AC-04/AC-11 | URL dan tiga field untuk empat role, akses bisnis opsional, guest ditolak, akun nonaktif/invalid/terhapus tidak dapat save. |
| FR-02/FR-05, AC-02/AC-03/AC-05 | Hash berubah, old/new credential login, field kosong/notifikasi, payload target/identitas/role/status diabaikan, current salah/minimum/konfirmasi/sama/bcrypt byte/null ditolak tanpa perubahan sesi/token. |
| FR-02 | Spasi dipertahankan, 72 byte diterima, 74 byte multibyte ditolak, password legacy pendek/panjang tetap diverifikasi, input menyerupai hash dianggap plaintext. |
| FR-05, AC-06/AC-07 | Form lama sesudah reset ditolak; marker hilang/stale; request endpoint Livewire aktual, upload bertanda tangan, dan unduhan bukti menolak sesi stale. |
| FR-05, AC-07 | Dua sesi database: sesi saat ini ber-ID baru tetap diterima; sesi lain dihapus; baris sesi lama yang direka ulang dengan payload lama tetap ditolak; penolakan tidak merotasi remember token baru. |
| FR-05/FR-06, AC-08/AC-09 | Reset akun lain mencabut sesi/token target saja, edit kosong mempertahankan, self-reset hidden dan payload ditolak, edit nama sendiri tetap tersedia, reset+email membersihkan token email lama. |
| FR-05 | Kegagalan cleanup yang disimulasikan setelah penghapusan token menyebabkan rollback hash, remember/reset token, dan mempertahankan ID sesi. |
| FR-05 | Cookie remember sah diterima; token/hash cookie lama ditolak; login baru dengan Ingat Saya tetap berhasil ketika cookie lama ada. |
| FR-07, AC-10 | Lima percobaan akun termasuk input kosong, 20 percobaan lintas akun pada IP sama, expiry 61 detik, dan penolakan ketika increment atomik melampaui batas setelah precheck. |
| AC-12 | Suite proyek dan test spec 001 memeriksa regresi akun, Humas, Pengaduan, bukti/hasil, dan fitur publik. |

Helper `actingAs` menyiapkan fingerprint sebagai fixture sesi terautentikasi. Test login HTTP dengan kredensial menggunakan listener login tanpa helper ini. Test Livewire aktual memakai snapshot HTML dan URI update terdaftar dengan middleware aktif, melengkapi test komponen yang melewati middleware pada harness Livewire.

## 2. Pemeriksaan UI

Preview memakai SQLite dan akun dummy terpisah, sesi file dengan cookie tersendiri, HTTP keluar dicegah, dan queue dipalsukan. Login FAP/Kepala tetap menuju Pengaduan, menu akun menampilkan Ubah Password, dan form hanya berisi tiga input. Kembali Kepala Balai terverifikasi menuju Pengaduan. Humas tetap menampilkan Dasbor/Berita/Komentar dan form password sendiri dengan Kembali ke dashboard. Manajemen Akun admin sendiri menampilkan tautan Ubah Password, tanpa field reset/password konfirmasi; detail form password admin juga diperiksa.

Pergantian password melalui UI browser tidak dilakukan. Simpan, validasi, input kosong, dan revokasi dibuktikan dengan test otomatis; tidak ada password operasional yang diganti.

- [Ubah Password FAP](screenshots/fap-ubah-password.jpg)
- [Ubah Password Kepala Balai](screenshots/kepala-balai-ubah-password.jpg)

## 3. Batas verifikasi

Test memakai Laravel 13.2.0, Filament 5.4.2, Livewire 4.2.2, PHP 8.3.24, SQLite, dan driver sesi array/database. Preview membuktikan UI/login dengan driver file. Redis serta dua transaksi MySQL paralel belum diuji. Test limiter mensimulasikan counter melewati batas sesudah precheck; tidak diklaim sebagai benchmark beberapa worker MySQL/cache paralel.

Atomic rollback dibuktikan pada koneksi database yang sama. Deployment dengan session/password broker pada koneksi berbeda membutuhkan verifikasi tambahan karena tidak menjadi satu transaksi database. Sesi existing tanpa fingerprint memerlukan login ulang. Tidak ada migration baru atau perubahan akun operasional. Rincian penggunaan ada pada [deployment.md](deployment.md).
