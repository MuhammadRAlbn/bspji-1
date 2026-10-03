# Verifikasi: Riwayat Penghapusan Pengaduan

Tanggal: 3 Oktober 2026 (Asia/Jakarta). Status: implementasi selesai; **306 test lulus, 2.248 assertion, tanpa kegagalan**.

## 1. Urutan spec driven development

Spec, plan, dan tasks disimpan sebelum test dan perubahan aplikasi. Test awal sebelum implementasi terhalang akses bootstrap PHPUnit dari sandbox Windows. Setelah menjalankan proses PHP dengan akses workspace yang sesuai, satu test penerimaan awal gagal karena ZonaIntegritasPengaduanDeletionService belum tersedia (1 gagal, 0 assertion). Ini bukti test awal sebelum implementasi, bukan hasil fitur akhir.

Test fitur baru mencakup 45 case, termasuk dialog daftar/header, alasan tidak valid, otorisasi status/role, payload metadata, kegagalan persistence, identitas akun terhapus, request lama, histori, unduhan, serta pelacakan publik. Fixture dan pemanggilan action test diperbaiki saat iterasi tanpa mengurangi aturan bisnis. Putaran fokus setelah perbaikan: 5 test lulus, 85 assertion, 10,24 detik. Suite seluruh proyek lulus **306 test (2.248 assertion), 508,88 detik**; mencakup fitur akun/password, Humas, pengaduan, dan dokumen existing. Pint pada seluruh file PHP fitur dan git diff --check lulus.

Penyesuaian akhir hanya pada susunan menu/pembungkusan teks dan format tanggal tabel riwayat. Dua test render/pencarian riwayat admin/Kepala Balai dijalankan kembali: **2 lulus, 40 assertion, 8,97 detik**. Pint --test resource juga lulus. Suite penuh tidak diulang untuk perubahan tampilan tersebut.

## 2. Matriks verifikasi

| Persyaratan | Bukti |
| --- | --- |
| FR-01 | Policy/service status Ditolak saja; role/nonaktif/actor terhapus/status terbaru; dialog lama; bulk action dilepas. |
| FR-02 | Dialog daftar/header, cancel, alasan wajib termasuk whitespace Unicode, batas panjang/tipe, serta escaping pada detail. |
| FR-03 | Data/lampiran dipertahankan, snapshot identitas dari server, payload palsu diabaikan, rollback pada event updating/trashed, dan penghapusan ulang ditolak. |
| FR-04 | URL/komponen untuk admin/Kepala Balai, pencarian riwayat, hanyaTrashed, penolakan FAP/Humas/nonaktif/tamu, dan pemeriksaan ulang akses sesudah mount. |
| FR-05 | Riwayat tanpa route mutasi; policy menolak edit/hapus/restore/force delete; model menolak save/restore/force delete/delete ulang; form lama gagal sebelum menyimpan. |
| FR-06 | Pelacakan publik kosong untuk record terhapus, unduhan existing 404, unduhan riwayat berizin, file hilang/record aktif/jenis file tidak sah ditolak. |

## 3. Database dan UI

Migration tambahan diterapkan pada MySQL development lokal setelah status Pending diperiksa. Pemeriksaan ulang menunjukkan **Ran, batch 75**. Migration menambah metadata dan indeks; tidak ada akun/pengaduan operasional yang dihapus. Route list menunjukkan hanya tiga route baru: daftar riwayat, detail riwayat, dan unduhan terautentikasi; tidak ada route mutasi riwayat.

Preview browser berjalan dengan SQLite/akun dummy/sesi file/storage terpisah. Admin melihat Hapus hanya pada pengaduan Ditolak; dialog menampilkan alasan wajib dan dapat dibatalkan. Daftar/detail riwayat menampilkan pelaku, waktu, alasan lengkap, laporan asli, dan tautan unduhan internal. Kepala Balai login ke Pengaduan dan memperoleh dua tab Pengaduan/Riwayat Penghapusan tanpa edit/hapus. Penghapusan melalui browser tidak dikonfirmasi; keberhasilan penghapusan, rollback, dan cancel dibuktikan dengan test otomatis. Tidak ada data operasional yang digunakan dalam preview.

- [Dialog alasan penghapusan](screenshots/dialog-alasan-penghapusan.jpg).
- [Riwayat Penghapusan Kepala Balai](screenshots/riwayat-penghapusan-kepala-balai.jpg).

## 4. Batas verifikasi

Suite memakai Laravel 13.2.0, Filament 5.4.2, PHP 8.3.24, dan SQLite in-memory. Kegagalan transaksi disimulasikan dalam satu koneksi database. Migration MySQL lokal dijalankan; dua transaksi MySQL paralel belum diuji. Perlindungan aplikasi tidak diklaim menghalangi operator yang mengubah database/storage langsung. Histori tidak dapat membuat ulang pengaduan yang sudah dihapus permanen sebelum fitur diaktifkan.
