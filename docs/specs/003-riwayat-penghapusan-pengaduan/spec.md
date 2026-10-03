# Spesifikasi: Riwayat Penghapusan Pengaduan

Tanggal: 3 Oktober 2026 (Asia/Jakarta).

Status: **Aturan bisnis disetujui pengguna pada 3 Oktober 2026. Spesifikasi dan test ditulis sebelum implementasi; implementasi selesai. Suite proyek lulus 306 test (2.248 assertion). Migration telah Ran pada MySQL development lokal.**

Acuan: [001 — Manajemen Akun dan Akses Pengaduan](../001-manajemen-akun-pengaduan/spec.md), [002 — Pergantian Password Mandiri](../002-pergantian-password-mandiri/spec.md).

## 1. Tujuan

Admin dapat membersihkan daftar pengaduan yang sudah ditolak tanpa menghilangkan laporan, lampiran, maupun bukti siapa yang menghapus dan alasannya. Admin dan Kepala Balai dapat memeriksa Riwayat Penghapusan melalui panel. Fitur tidak menyediakan pemulihan.

## 2. Keputusan yang disepakati

| ID | Keputusan | Dasar |
| --- | --- | --- |
| D-01 | Hanya admin aktif dapat menghapus pengaduan berstatus Ditolak. | Usulan terakhir disetujui pengguna. |
| D-02 | Alasan penghapusan wajib ditulis manual; kosong atau hanya spasi ditolak. | Pengguna meminta alasan yang spesifik menjelaskan penolakan dan penghapusan. |
| D-03 | Pengaduan dan lampirannya dipertahankan menggunakan soft delete. | Disepakati agar daftar aktif bersih dan laporan tetap dapat diperiksa. |
| D-04 | Riwayat mencatat alasan, identitas admin, dan waktu penghapusan; hanya admin dan Kepala Balai dapat membaca. | Usulan terakhir disetujui pengguna. |
| D-05 | Riwayat tidak dapat diubah/dihapus melalui panel; tidak ada pemulihan atau persetujuan tambahan. | Pengguna meminta alur sederhana dan menyetujui cakupan terakhir. |

## 3. Baseline sebelum implementasi

- Pengaduan menyediakan DeleteAction pada daftar dan header edit serta DeleteBulkAction; aksi belum meminta alasan.
- Policy membatasi delete/deleteAny pada admin aktif, tetapi belum membatasi status Ditolak.
- Model belum memakai SoftDeletes atau menyimpan metadata penghapusan. Akun panel dapat dihapus permanen melalui Manajemen Akun.
- FAP dapat mengubah tindak lanjut; Kepala Balai hanya membaca. Gate dan middleware memakai daftar izin eksplisit untuk staf pengaduan.
- Pelacakan publik serta route unduhan existing menggunakan query/binding pengaduan biasa.
- Baseline hasil suite terakhir dalam spec 002: 261 test, 1.997 assertion. Ini hasil historis, bukan pengujian fitur 003.

## 4. Matriks akses

| Kemampuan | Admin aktif | Kepala Balai aktif | FAP aktif | Humas/tamu/nonaktif/role tidak valid |
| --- | --- | --- | --- | --- |
| Membaca pengaduan aktif | Ya | Ya | Ya | Mengikuti larangan spec 001 |
| Menghapus pengaduan Ditolak dengan alasan | Ya | Tidak | Tidak | Tidak |
| Menghapus pengaduan pada status lain | Tidak | Tidak | Tidak | Tidak |
| Membaca daftar/detail/lampiran riwayat | Ya | Ya | Tidak | Tidak |
| Mengubah, menghapus permanen, atau memulihkan riwayat | Tidak | Tidak | Tidak | Tidak |

## 5. Persyaratan fungsional

### FR-01 — Penghapusan terbatas

Aksi Hapus pada baris daftar dan header edit tersedia hanya untuk admin aktif pada pengaduan Ditolak yang belum dihapus. Server memeriksa akun dan pengaduan terbaru saat eksekusi; perubahan role, status aktif, atau status pengaduan setelah dialog dibuka harus menolak penghapusan. Hapus massal dilepas agar alasan diberikan per pengaduan.

### FR-02 — Dialog dan alasan manual

Dialog menampilkan nomor pengaduan dan menjelaskan bahwa laporan keluar dari daftar aktif serta tersimpan di riwayat. Input Alasan Penghapusan wajib diisi manual, dengan petunjuk: "Jelaskan alasan pengaduan ditolak dan perlu dihapus dari daftar." Batas teknis 2.000 karakter berlaku pada form dan server. Spasi di tepi dinormalisasi; input kosong/hanya spasi, tipe selain teks, dan input terlalu panjang ditolak. Isi alasan diperlakukan sebagai teks dan ditampilkan dengan escaping.

Membuka dialog atau membatalkan tidak mengubah data. Alasan bukan field laporan asli maupun perubahan otomatis atas hasil tindak lanjut.

### FR-03 — Penyimpanan dan keutuhan data

Simpan alasan, waktu penghapusan, dan snapshot ID/nama/email admin dari akun terautentikasi terbaru. Payload tidak boleh menentukan pelaku atau waktu. Snapshot identitas tetap tersedia setelah akun pelaku diganti namanya/emailnya atau dihapus.

Pengaduan asli, status Ditolak, hasil tindak lanjut, nomor, dan path/nama lampiran dipertahankan. File tidak dihapus. Metadata dan soft delete harus berhasil dalam satu transaksi; kegagalan salah satunya membatalkan seluruh perubahan. Eksekusi ulang/penghapusan bersamaan tidak boleh menimpa alasan atau pelaku penghapusan pertama.

### FR-04 — Riwayat yang hanya dapat dibaca

Menu Riwayat Penghapusan berada dalam Zona Integritas untuk admin dan Kepala Balai. Daftar hanya menampilkan pengaduan terhapus, diurutkan waktu penghapusan terbaru, dengan nomor, judul, pelaku, waktu, serta ringkasan alasan. Nomor/judul/pelaku/alasan dapat dicari. Detail menampilkan alasan lengkap, snapshot identitas, laporan asli, tindak lanjut, dan unduhan lampiran yang masih tersedia.

FAP/Humas tidak mendapat akses menu, URL langsung, komponen Livewire, maupun endpoint unduhan riwayat. Pemeriksaan sesi/akun terbaru juga berlaku pada halaman atau URL yang sudah terbuka.

### FR-05 — Histori tidak dapat dimutasi

Riwayat tidak menyediakan edit, hapus, bulk delete, force delete, restore, atau upload. Policy menolak operasi perubahan terhadap pengaduan terhapus, termasuk formulir pengaduan aktif yang dibuka sebelum penghapusan. Penjagaan model menolak perubahan, restore, force delete, dan delete biasa tanpa metadata penghapusan yang wajib.

Batas jaminan fitur adalah aplikasi/panel dan service yang digunakan aplikasi. Query database langsung oleh operator dengan hak database bukan cakupan perlindungan ini. Tidak ada tabel audit lintas fitur atau fitur antitamper database pada tahap ini.

### FR-06 — Daftar aktif dan akses dokumen

Pengaduan terhapus tidak muncul dalam daftar/detail/edit aktif, pencarian pelacakan publik, atau unduhan bukti/hasil existing. URL existing untuk pengaduan terhapus memberi 404. Pengaduan aktif tetap mengikuti perilaku spec 001/002, termasuk hasil yang dapat diunduh publik.

Unduhan riwayat memakai endpoint terpisah dengan autentikasi, pemeriksaan sesi, dan izin admin/Kepala Balai. Endpoint hanya mengambil file yang terkait dengan record terhapus yang diizinkan; file hilang memberikan 404. Tidak ada URL storage publik baru.

## 6. Skenario penerimaan

| ID | Skenario | Hasil yang diharapkan | Acuan |
| --- | --- | --- | --- |
| AC-01 | Admin menghapus pengaduan Ditolak dari daftar atau header edit | Hilang dari daftar aktif; record, lampiran, dan metadata lengkap tersimpan. | FR-01–FR-03 |
| AC-02 | Admin membuka/membatalkan dialog | Pengaduan dan metadata tetap. | FR-02 |
| AC-03 | Alasan kosong, hanya spasi, bukan teks, atau lebih dari 2.000 karakter | Validasi menolak tanpa penghapusan. | FR-02 |
| AC-04 | Admin memakai alasan valid termasuk teks HTML | Alasan dinormalisasi dan tampil sebagai teks; bukan HTML yang dieksekusi. | FR-02 |
| AC-05 | Status selain Ditolak/nonadmin/nonaktif mencoba hapus atau bulk delete | Ditolak; data dan file tidak berubah; bulk action tidak tersedia. | FR-01 |
| AC-06 | Status/role/akun berubah setelah dialog dibuka | Eksekusi memakai data terbaru dan ditolak. | FR-01 |
| AC-07 | Payload memalsukan pelaku/waktu/field asli | Metadata berasal dari server; laporan asli tetap. | FR-03 |
| AC-08 | Penulisan metadata atau soft delete gagal | Transaksi membatalkan seluruh perubahan; pengaduan tetap aktif. | FR-03 |
| AC-09 | Request ulang memakai record lama | Alasan/pelaku/waktu pertama tidak ditimpa. | FR-03 |
| AC-10 | Admin/Kepala Balai membuka riwayat dan detail | Hanya pengaduan terhapus terlihat; data lengkap dan pencarian tersedia. | FR-04 |
| AC-11 | FAP/Humas/tamu/nonaktif mengakses riwayat/unduhan | Akses ditolak/login diperlukan, termasuk URL langsung dan komponen lama. | FR-04, FR-06 |
| AC-12 | Akun pelaku diganti identitas atau dihapus | Snapshot nama/email/ID saat penghapusan tetap terbaca. | FR-03 |
| AC-13 | Form aktif lama menyimpan setelah record dihapus | Ditolak sebelum perubahan data/file; histori tidak berubah. | FR-05 |
| AC-14 | Percobaan edit/restore/force delete/delete ulang terhadap histori | Ditolak; tidak ada aksi/route mutasi riwayat. | FR-05 |
| AC-15 | Pelacakan publik dan URL unduhan existing memakai pengaduan terhapus | Data terhapus tidak tersedia; lampiran masih dapat dibaca lewat endpoint riwayat oleh role berwenang. | FR-06 |
| AC-16 | Lampiran hilang atau endpoint riwayat memakai record aktif | 404; file pengaduan lain tidak terpapar. | FR-06 |

## 7. Di luar cakupan

Pemulihan, approval penghapusan, penghapusan massal, penghapusan permanen dari panel, perubahan alur penolakan yang sudah ada, audit seluruh perubahan status, ekspor histori, notifikasi baru, purge/retensi otomatis, dan pemulihan data yang telah dihapus permanen sebelum fitur ini tersedia.

## 8. Metode pengembangan

Aturan bisnis D-01–D-05 telah disetujui dalam percakapan. Spesifikasi dan rencana disimpan sebelum test penerimaan serta perubahan aplikasi. Eksekusi test awal terhalang akses bootstrap PHPUnit dari sandbox Windows; setelah memakai akses proses PHP yang sesuai, satu test awal gagal karena service penghapusan belum tersedia. Implementasi kemudian ditulis dan diperiksa dengan test penerimaan serta regresi. Rincian teknis pada [plan.md](plan.md), checklist pada [tasks.md](tasks.md), hasil aktual pada [verification.md](verification.md), dan panduan aktivasi pada [deployment.md](deployment.md).

## 9. Referensi teknis

- [Laravel 13 — Soft Deleting](https://laravel.com/framework/docs/13.x/eloquent#soft-deleting): record dipertahankan dan dikecualikan dari query biasa.
- [Filament 5 — Delete Action](https://filamentphp.com/docs/5.x/actions/delete): dialog konfirmasi dan penggantian proses memakai implementasi action versi terpasang.
