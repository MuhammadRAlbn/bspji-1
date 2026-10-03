# Hasil Verifikasi Implementasi

Tanggal: 3 Oktober 2026 (Asia/Jakarta); verifikasi awal/FR-11 dilakukan pada 2 Oktober 2026.

Status terbaru: implementasi termasuk hapus akun FR-11, integrasi pergantian password spec 002, dan histori penghapusan spec 003 selesai diverifikasi. Suite proyek terbaru lulus **306 test (2.248 assertion)**, durasi 508,88 detik; hasil/batasnya pada [verifikasi spec 003](../003-riwayat-penghapusan-pengaduan/verification.md). Hasil setelah spec 002 (261 test, 1.997 assertion, 405,61 detik) tersedia pada [verifikasi spec 002](../002-pergantian-password-mandiri/verification.md). Hasil 2 Oktober dipertahankan sebagai riwayat di bawah.

## 1. Hasil otomatis

| Pemeriksaan | Hasil |
| --- | --- |
| Baseline Pengaduan, News/Humas, dan SPM Pengujian sebelum implementasi | 27 test lulus, 142 assertion. |
| Test penerimaan awal sebelum implementasi | 34 gagal, 3 lulus: default admin, halaman/komponen yang belum ada, akses dokumen, dan tujuan login belum sesuai spec. |
| Test tambahan sesi dan upload setelah pencabutan akses sebelum perbaikan | 3 gagal; login masih mengalihkan sesi nonaktif dan URL upload lama masih diterima. |
| Test fitur awal sebelum FR-11 | 50 test lulus, 487 assertion. |
| Suite proyek implementasi awal sebelum FR-11 | 203 test lulus, 1.539 assertion; durasi 208,79 detik. |
| Test penerimaan hapus akun sebelum implementasi FR-11 | 21 case tambahan gagal saat aksi/service delete belum tersedia; test cleanup diperiksa ulang setelah fixture diperbaiki dan tetap gagal karena service belum tersedia. |
| Manajemen Akun setelah FR-11 | **35 test lulus, 167 assertion**, termasuk 21 case baru untuk hapus akun; durasi 36,84 detik. |
| Suite historis 2 Oktober setelah FR-11 dan Pint | **224 test lulus, 1.626 assertion**, tanpa test gagal; durasi 373,82 detik. |
| Suite terbaru 3 Oktober setelah spec 002 | **261 test lulus, 1.997 assertion**, tanpa test gagal; durasi 405,61 detik. |
| Laravel Pint | Dijalankan pada seluruh file PHP fitur yang berubah/baru; formatting diperbaiki. |

Test penerimaan utama:

- `tests/Feature/Filament/Users/UserResourceTest.php`: default nonprivileged, akun FAP/Kepala Balai, validasi, password edit/reset, akses nonadmin, proteksi admin, perubahan akses saat form terbuka, dan pemulihan halaman login sesudah sesi dicabut. FR-11 menambahkan konfirmasi/batal, delete dari daftar/header dan redirect, seluruh role/status target, larangan self/last admin dan bulk delete, actor stale/terhapus, cleanup sesi/reset token target saja, konten pengaduan tetap ada, serta penolakan login/form/upload lama setelah akun dihapus.
- `tests/Feature/Filament/ZonaIntegritas/PengaduanAccessTest.php`: daftar/detail, filter/search, seluruh resource terdaftar, navigasi, read-only Kepala Balai, update FAP, delete/bulk delete, field immutable, status, penyelesaian, file/path/metadata, serta replay URL upload setelah revocation.
- `tests/Feature/ZonaIntegritasPengaduanDownloadAccessTest.php`: unduhan bukti untuk setiap role/status aktif, login tamu, file hilang, dan baseline hasil publik.

Regresi meliputi test existing pada suite proyek, termasuk Humas, batas resource SPM, pengiriman/penomoran/notifikasi/pelacakan pengaduan, serta fitur publik lainnya.

## 2. Pemeriksaan browser

Preview memakai database SQLite terpisah dan akun/data contoh. Akun tersebut tidak dibuat pada database aplikasi utama. Permintaan HTTP keluar dan queue notifikasi dinonaktifkan untuk preview.

- Admin: login, daftar Manajemen Akun, form Buat/Ubah Akun, empat pilihan role, ringkasan izin FAP, kontrol aktif, dan password edit kosong tanpa menampilkan hash.
- Kepala Balai: login langsung ke Pengaduan, hanya navigasi Zona Integritas/Pengaduan, aksi Lihat tanpa Edit/Delete, dan detail lengkap baca saja.
- FAP: login langsung ke Pengaduan, Lihat/Ubah tanpa Delete, laporan asli disabled, serta penyimpanan hasil dan status investigasi yang terkonfirmasi pada daftar.
- Humas: login ke dashboard dengan menu Berita/Komentar yang sudah ada; Manajemen Akun dan Pengaduan tidak ditampilkan.
- Penambahan FR-11: pada preview SQLite terpisah, daftar menampilkan Hapus untuk FAP contoh dan hanya Ubah untuk admin yang sedang login. Dialog daftar/header edit menampilkan nama/email target dan penjelasan permanen. Batal menutup dialog dan mempertahankan akun. Penghapusan terkonfirmasi dan redirect diuji melalui Livewire; pemeriksaan browser tidak menghapus akun operasional.

Bukti tampilan:

- [Form Manajemen Akun](screenshots/manajemen-akun.jpg)
- [Detail Kepala Balai](screenshots/kepala-balai-detail.jpg)
- [Tindak lanjut FAP tersimpan](screenshots/fap-tindak-lanjut.jpg)
- [Konfirmasi Hapus Akun](screenshots/hapus-akun-konfirmasi.jpg)

## 3. Batas verifikasi dan aktivasi

Pada verifikasi awal, MySQL lokal tidak menerima koneksi. Pemeriksaan read-only pada 2 Oktober 2026 saat penambahan FR-11 berhasil: `php artisan migrate:status` menunjukkan dua migration akun sudah **Ran**, batch 74. Panduan pada [deployment.md](deployment.md) telah disesuaikan. Pemeriksaan ini tidak mencatat atau mengubah akun operasional.

Test SQLite memverifikasi guard admin dan actor yang role-nya sudah dicabut/terhapus. SQLite tidak memverifikasi penguncian dua transaksi MySQL secara paralel. Implementasi perubahan dan penghapusan akun memakai query lock bersama dalam transaksi dan `lockForUpdate()` dengan urutan ID konsisten serta pemeriksaan ulang actor/target. Uji konkurensi MySQL paralel belum dilakukan; pengujian tersebut perlu database uji terpisah.

Unduhan hasil publik tetap mengikuti baseline yang disepakati. Izin internal baru tidak mengubah hasil publik menjadi dokumen khusus staf.

Perubahan Pengujian/Sertifikasi yang sudah ada sebelum pekerjaan ini tidak diubah oleh implementasi fitur ini. Tidak ada dependency baru, commit, atau deployment yang dibuat.
