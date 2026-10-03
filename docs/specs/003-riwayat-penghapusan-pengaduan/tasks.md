# Daftar Pekerjaan: Riwayat Penghapusan Pengaduan

Acuan: [spec.md](spec.md), [plan.md](plan.md). Aturan bisnis disetujui 3 Oktober 2026; implementasi selesai. Suite proyek lulus 306 test (2.248 assertion); migration lokal Ran, batch 75.

## T-00 — Spesifikasi

- [x] Tinjau model, policy, daftar/edit/detail, unduhan/pelacakan publik, gate, middleware staf, dan pola service.
- [x] Catat persetujuan: Ditolak saja, alasan manual wajib, soft delete, histori admin/Kepala Balai, tanpa pemulihan.
- [x] Susun FR-01–FR-06, AC-01–AC-16, skema, rencana, serta batas cakupan sebelum implementasi.

## T-01 — Test penerimaan

- [x] Tulis test service, dialog daftar/header, alasan, role/status, payload, rollback, dan request stale.
- [x] Tulis test riwayat, identitas pelaku setelah perubahan/hapus akun, immutability, serta unduhan/publik.
- [x] Jalankan dan catat hasil awal sebelum implementasi: satu test gagal karena service belum tersedia setelah hambatan sandbox bootstrap ditangani.

## T-02 — Implementasi

- [x] Buat migration metadata penghapusan, SoftDeletes, serta penjagaan model.
- [x] Implementasikan satu service dan aksi penghapusan dengan alasan manual.
- [x] Batasi policy pada Ditolak, lepas bulk delete, dan tambahkan izin riwayat.
- [x] Tambahkan resource/halaman riwayat baca saja dan penyesuaian gate/middleware staf.
- [x] Tambahkan unduhan riwayat terautentikasi dengan tetap mengecualikan data terhapus dari publik.

## T-03 — Verifikasi dan dokumentasi

- [x] Jalankan test terkait, Pint, diff check, dan suite proyek: 306 lulus, 2.248 assertion. Setelah penyesuaian tampilan saja, dua test render/pencarian admin/Kepala Balai lulus (40 assertion).
- [x] Periksa UI admin dan Kepala Balai dengan data uji terpisah: dialog alasan/batal, menu, daftar, serta detail riwayat. Penghapusan browser tidak dikonfirmasi; perilaku simpan diuji otomatis.
- [x] Perbarui spec 001, referensi hasil spec 002, panduan aktivasi, hasil verifikasi, serta status dokumen.
- [x] Nyatakan status migration MySQL development lokal: Ran, batch 75. Suite memakai SQLite; transaksi MySQL paralel belum diuji.
