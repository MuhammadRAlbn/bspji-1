# Spesifikasi: Akses Baca Riwayat Penghapusan untuk FAP

Tanggal: 4 Oktober 2026 (Asia/Jakarta).

Status: **Implementasi selesai. Spesifikasi dan test penerimaan ditulis sebelum perubahan aplikasi. Suite proyek lulus 338 test (2.507 assertion).**

Acuan: [003 — Riwayat Penghapusan Pengaduan](../003-riwayat-penghapusan-pengaduan/spec.md) dan [004 — Penghapusan oleh FAP dan Tampilan Waktu WIB](../004-penghapusan-fap-waktu-wib/spec.md). Spesifikasi ini menggantikan pembatasan akses baca histori FAP pada kedua baseline tersebut.

## Tujuan dan keputusan

FAP yang menangani serta menghapus pengaduan perlu memeriksa catatan penghapusan melalui panel. FAP aktif memperoleh akses baca yang sama dengan admin/Kepala Balai: seluruh daftar riwayat, detail, alasan, identitas penghapus, laporan asli, dan lampiran yang tersedia. Cakupan mengikuti akses pengaduan yang sudah meliputi seluruh laporan, bukan hanya penghapusan milik akun sendiri.

| Kemampuan | Admin aktif | FAP aktif | Kepala Balai aktif | Humas/nonaktif/role tidak valid/tamu |
| --- | --- | --- | --- | --- |
| Membaca seluruh riwayat, detail, dan lampiran | Ya | Ya | Ya | Tidak; tamu perlu login |
| Menghapus pengaduan aktif berstatus Ditolak dengan alasan | Ya | Ya | Tidak | Tidak |
| Mengedit, menghapus ulang/permanen, atau memulihkan riwayat | Tidak | Tidak | Tidak | Tidak |

## Persyaratan

- **FR-01 — Menu dan halaman:** FAP aktif mendapat menu Zona Integritas > Riwayat Penghapusan. Daftar, pencarian, URL detail, dan komponen Livewire mengizinkan FAP membaca penghapusan oleh dirinya, admin, serta FAP lainnya. Hanya record terhapus yang termasuk histori.
- **FR-02 — Dokumen:** endpoint riwayat yang sudah ada mengizinkan FAP aktif mengunduh bukti dan dokumen hasil yang terkait dengan record. Pemeriksaan autentikasi, sesi, jenis dokumen, izin record, serta file hilang tetap berlaku.
- **FR-03 — Akses terbaru:** halaman daftar/detail yang sudah terbuka dan unduhan tetap memeriksa akun terkini. FAP yang dinonaktifkan atau berubah menjadi Humas/role tanpa hak ditolak. Perubahan antara role pembaca yang sah, termasuk Kepala Balai menjadi FAP, tetap diperbolehkan.
- **FR-04 — Keutuhan histori:** akses baru hanya membaca. Tidak ada edit, upload, delete, bulk delete, restore, atau force delete pada riwayat. Alasan, identitas, timestamp, soft delete, dan lampiran tetap mengikuti spec 003/004.
- **FR-05 — Konsistensi izin:** policy, Gate, dan middleware panel membuka kemampuan baca histori FAP secara selaras. Akses FAP ke resource lain tetap terbatas sesuai aturan sebelumnya. Deskripsi role FAP menyebut kemampuan membaca riwayat.

## Skenario penerimaan

| ID | Skenario | Hasil |
| --- | --- | --- |
| AC-01 | FAP menghapus pengaduan Ditolak lalu membuka riwayat | Menu/daftar/detail menampilkan pengaduan dengan alasan dan identitas yang benar. |
| AC-02 | FAP membuka riwayat penghapusan admin atau FAP lain | Detail, pencarian, bukti, serta dokumen hasil dapat dibaca. |
| AC-03 | FAP mencoba mutasi histori atau membuka record aktif melalui URL histori | Mutasi ditolak; record aktif memberi 404. |
| AC-04 | FAP nonaktif/Humas/tamu mengakses halaman atau lampiran histori | Ditolak atau login diperlukan. |
| AC-05 | Hak pembaca dicabut setelah daftar/detail dibuka | Refresh halaman/komponen dan kedua unduhan ditolak. |
| AC-06 | Kepala Balai berubah menjadi FAP setelah halaman dibuka | Tetap dapat membaca; tidak dianggap pencabutan akses. |
| AC-07 | FAP membuka resource di luar pengaduan/histori | Tetap ditolak. |

## Implementasi dan verifikasi

Rencana: [plan.md](plan.md). Checklist: [tasks.md](tasks.md). Aktivasi: [deployment.md](deployment.md). Hasil aktual: [verification.md](verification.md).

Tidak ada migration, perubahan alur penghapusan, atau perubahan WIB. Baseline sebelumnya: 332 test, 2.434 assertion pada spec 004.
