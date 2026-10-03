# Daftar Pekerjaan: Pergantian Password Mandiri

Acuan: [spec.md](spec.md), [plan.md](plan.md). Status: **spesifikasi disetujui pada 3 Oktober 2026; implementasi selesai, suite proyek lulus 261 test (1.997 assertion)**.

## T-00 — Spesifikasi dan persetujuan

- [x] Tinjau panel, login response, batas akses staf, UserManagementService, form admin, dan source EditProfile/AuthenticateSession.
- [x] Catat pilihan pengguna: opsional dan tetap minimal 12 karakter.
- [x] Susun FR-01–FR-07, AC-01–AC-12, rencana sesi/admin, serta batas cakupan.
- [x] Sepakati seluruh spec, termasuk sesi perangkat lain dan jalur admin sendiri.
- [x] Susun mekanisme revokasi memakai fingerprint hash existing, inisialisasi login terpercaya, dan penjagaan request stale tanpa rencana migration baru.
- [x] Mulai implementasi setelah pengguna menyetujui seluruh spesifikasi.

## T-01 — Test penerimaan (sesudah persetujuan)

- [x] Tulis test akses seluruh role, akun sendiri, dan perlindungan payload (AC-01, AC-05, AC-11).
- [x] Tulis test validasi/pergantian opsional dan penggantian berhasil (AC-02–AC-04).
- [x] Tulis test sesi, actor stale, reset admin, serta rate limit (AC-06–AC-10).
- [x] Catat eksekusi awal yang terhalang bootstrap ACL Windows sebelum implementasi; tidak mengklaim test merah terverifikasi.

## T-02 — Implementasi (sesudah persetujuan)

- [x] Buat halaman/menu Ubah Password dengan tiga input dan tujuan Kembali sesuai role.
- [x] Implementasikan service mandiri, current password, locking, validasi batas hasher, dan whitelist field.
- [x] Sesuaikan reset admin agar hanya akun lain bisa direset tanpa current password.
- [x] Implementasikan rotasi sesi saat ini, pencabutan sesi lain/remember/reset token, serta guard Livewire/upload/bukti.
- [x] Tambah pengecualian route keamanan akun sendiri bagi FAP/Kepala Balai dan pertahankan pembatasan bisnis.
- [x] Terapkan pembatasan percobaan akun/IP.

## T-03 — Verifikasi dan dokumentasi (sesudah persetujuan)

- [x] Jalankan test terkait, Pint, dan suite proyek setelah perubahan middleware/otorisasi.
- [x] Periksa UI seluruh role serta dua sesi dengan data uji terpisah.
- [x] Periksa bahwa alur opsional tidak membuat redirect wajib ganti atau memblokir fitur bisnis.
- [x] Perbarui spec 001 yang terdampak, panduan penggunaan/migration, dan hasil verifikasi berdasarkan keadaan terbaru.
- [x] Catat konfigurasi driver sesi, hasil konkurensi yang benar-benar diuji, serta pekerjaan yang masih tersisa.

## Hasil akhir dan batas pengujian

Suite proyek: 261 test lulus, 1.997 assertion, 405,61 detik. Tidak ada migration baru atau perubahan akun operasional. Driver array/database diuji otomatis; file untuk preview UI. Dua sesi HTTP/database dan penolakan baris sesi lama yang direka ulang diverifikasi. Simpan password melalui browser tidak dilakukan; perilaku tersebut diuji otomatis. Redis dan transaksi MySQL paralel belum diuji; batas ini tercatat pada [verification.md](verification.md) dan bukan hasil yang diklaim lulus.
