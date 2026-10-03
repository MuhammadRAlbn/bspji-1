# Daftar Pekerjaan: Manajemen Akun dan Akses Pengaduan

Acuan perilaku: [spec.md](spec.md). Desain: [plan.md](plan.md).

Status: implementasi termasuk hapus akun (D-03/FR-11) selesai diverifikasi. Suite terbaru lulus 224 test (1.626 assertion). Dua migration awal telah Ran pada MySQL lokal; tidak ada migration tambahan untuk hapus akun. Lihat [verification.md](verification.md) dan [deployment.md](deployment.md). Tanda centang menunjukkan pekerjaan yang benar-benar telah dilakukan.

## T-00 — Spesifikasi

- [x] Tinjau User, panel, Gate, policy, resource Pengaduan, model, route/controller dokumen, migrations, dan pola test.
- [x] Konfirmasi D-01: role bawaan dan izin dalam kode.
- [x] Konfirmasi D-02: FAP hanya mengelola tindak lanjut, tanpa delete.
- [x] Susun matriks akses, persyaratan FR-01–FR-10, asumsi, dan AC-01–AC-16.
- [x] Susun rencana teknis dan urutan implementasi.

## T-01 — Test penerimaan akun dan otorisasi

- [x] Tulis test akun/role/default/status aktif dan proteksi admin (AC-01–AC-03, AC-13–AC-14).
- [x] Tulis test matriks policy untuk admin, Humas, FAP, Kepala Balai, role tidak valid, dan nonaktif (AC-05–AC-09, AC-15).
- [x] Catat kegagalan awal yang menunjukkan perilaku baru belum tersedia; jangan mengubah ekspektasi agar mengikuti implementasi yang keliru.

## T-02 — Data akun dan izin dasar

- [x] Buat migration baru untuk status aktif dan default role nonprivileged; pertahankan akun existing (FR-02–FR-03).
- [x] Tambah role/helper/canAccessPanel serta state factory yang diperlukan.
- [x] Tambah UserPolicy dan ZonaIntegritasPengaduanPolicy.
- [x] Sesuaikan Gate agar FAP/Kepala Balai ditolak pada model lain dan Humas tetap bekerja (FR-09).
- [x] Implementasikan guard penyimpanan akun terhadap deactivation/demotion diri dan hilangnya admin aktif (FR-04).
- [x] Jalankan test T-01 dan regression otorisasi existing.

## T-03 — Manajemen Akun

- [x] Buat resource daftar/tambah/edit yang hanya dapat diakses admin aktif (FR-01).
- [x] Tambah validasi email/role/password, ringkasan izin role, serta kontrol aktif/nonaktif.
- [x] Pastikan password edit kosong tidak mengganti hash dan nonadmin tidak dapat memanggil aksi akun (AC-03, AC-14).
- [x] Uji perubahan akses pada sesi/komponen yang sudah terbuka (AC-12).

## T-04 — Navigasi dan detail pengaduan

- [x] Tulis test login response, `/admin`, navigasi, seluruh resource terdaftar, dan URL terlarang (AC-04–AC-05).
- [x] Atur tujuan awal serta akses dashboard/page/widget untuk FAP/Kepala Balai (FR-05).
- [x] Tambah halaman Lihat Pengaduan dan aksi Lihat (FR-06).
- [x] Pastikan Kepala Balai tidak memiliki jalur edit/save/upload/delete/bulk delete (AC-06–AC-07).

## T-05 — Tindak lanjut dan dokumen

- [x] Tulis test update FAP, manipulasi field/file, delete/bulk delete, serta syarat selesai (AC-08–AC-11).
- [x] Batasi payload tindak lanjut dan validasi file/path pada server (FR-07).
- [x] Pastikan dokumen yang dihapus tidak dianggap memenuhi syarat selesai (FR-08).
- [x] Tambah otorisasi unduhan bukti dan tujuan login tamu; uji seluruh role serta file hilang (FR-10, AC-15).
- [x] Pertahankan dan uji alur publik yang sudah ada (AC-16).

## T-06 — Verifikasi dan penutupan

- [x] Jalankan feature tests terkait akun, Pengaduan, News/Humas, serta resource dengan batas bisnis existing.
- [x] Jalankan suite proyek setelah perubahan otorisasi terpusat selesai; catat kegagalan baseline jika ada.
- [x] Jalankan Pint pada file PHP yang berubah.
- [x] Periksa UI daftar/tambah/edit akun, login setiap role, navigasi, detail, edit FAP, dan read-only Kepala Balai dalam lingkungan uji.
- [x] Cocokkan hasil dengan setiap FR dan AC; perbarui dokumen untuk perubahan kebutuhan yang muncul.
- [x] Tulis instruksi migration dan pembuatan akun melalui panel tanpa kredensial hardcoded.
- [x] Tandai implementasi dan verifikasi selesai; catat aktivasi database utama yang masih tertunda secara terpisah.

## T-07 — Penambahan hapus akun (FR-11, AC-17–AC-19)

- [x] Konfirmasi D-03 dan perbarui spec, rencana, serta skenario penerimaan sebelum perubahan kode.
- [x] Tulis test penerimaan hapus akun dan catat kegagalan awal.
- [x] Implementasikan policy/service delete dengan proteksi admin, transaksi, actor/target terbaru, serta pembersihan sesi/token.
- [x] Tambah aksi Hapus dengan konfirmasi pada daftar/header edit; pertahankan larangan bulk delete.
- [x] Tangani sesi/komponen yang aktornya telah dihapus; uji login, hydrate, dan upload lama.
- [x] Jalankan test terkait, suite proyek, Pint, serta pemeriksaan UI dengan data uji terpisah.
- [x] Perbarui hasil verifikasi dan panduan penggunaan berdasarkan keadaan akhir, termasuk status database lokal terbaru yang benar-benar diperiksa.
