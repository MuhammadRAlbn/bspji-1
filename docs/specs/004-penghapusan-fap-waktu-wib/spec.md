# Spesifikasi: Penghapusan oleh FAP dan Tampilan Waktu WIB

Tanggal: 4 Oktober 2026 (Asia/Jakarta).

Status: **Implementasi selesai. Spesifikasi dan test utama ditulis sebelum perubahan aplikasi. Suite proyek lulus 332 test (2.434 assertion). Tidak diperlukan migration baru.**

Acuan: [003 — Riwayat Penghapusan Pengaduan](../003-riwayat-penghapusan-pengaduan/spec.md). Spesifikasi ini memperbarui akses penghapusan dan tampilan waktu; aturan lainnya tetap mengikuti 003.

## 1. Tujuan dan keputusan

Tim FAP dapat membersihkan pengaduan yang sudah ditolak tanpa bergantung pada admin. Penghapusan tetap mempertahankan laporan, lampiran, alasan manual, dan identitas penghapus. Tanggal/jam dalam panel mengikuti Waktu Indonesia Barat (Asia/Jakarta, UTC+7).

| ID | Keputusan |
| --- | --- |
| D-01 | Admin aktif dan FAP aktif dapat menghapus satu pengaduan berstatus Ditolak dari daftar atau header edit. |
| D-02 | Alasan wajib, soft delete, snapshot identitas, transaksi, serta larangan bulk delete/restore/force delete tetap berlaku. |
| D-03 | Akses membaca riwayat tetap khusus admin aktif dan Kepala Balai aktif. Permintaan akses hapus FAP tidak menambahkan akses membaca riwayat. |
| D-04 | Zona waktu tampilan default Filament memakai Asia/Jakarta. Waktu pengaduan dan penghapusan ditampilkan dalam format `dd/mm/yyyy HH:mm:ss WIB`. |
| D-05 | Aplikasi dan penyimpanan timestamp tetap memakai UTC; data lama tidak ditulis ulang. Konversi dilakukan saat tampilan, sehingga pergantian hari dan tahun mengikuti WIB. Field yang hanya menyimpan tanggal tidak dikonversi seperti timestamp. |

## 2. Persyaratan fungsional

- **FR-01 — Hak hapus:** policy mengizinkan admin/FAP aktif hanya untuk pengaduan Ditolak yang belum terhapus. Service tetap memeriksa akun dan status terbaru di dalam transaksi. Akun nonaktif, role lainnya, status selain Ditolak, atau record terhapus ditolak.
- **FR-02 — Akuntabilitas FAP:** dialog dan validasi alasan sama untuk kedua role. ID/nama/email penghapus berasal dari akun terbaru di server, termasuk FAP. Label identitas dalam histori menyebut akun/penghapus dan tidak khusus admin. File/laporan asli tetap tersimpan.
- **FR-03 — Batas akses:** FAP tetap tidak dapat membaca histori melalui menu, URL, komponen, atau unduhan. Kepala Balai tetap tidak dapat menghapus. Tidak ada penghapusan massal atau perubahan alur penolakan/spam.
- **FR-04 — WIB:** tanggal/jam dikirim, terakhir diubah, selesai, dan dihapus tampil dalam WIB pada daftar/detail pengaduan dan histori. Null tetap memakai placeholder. Default datetime Filament lain mengikuti WIB, sedangkan tanggal tanpa jam mempertahankan tanggalnya. Input tanggal publikasi berita menjelaskan penggunaan WIB dan mengonversi waktu input kembali ke UTC saat disimpan.
- **FR-05 — Data lama dan baru:** timestamp asli tetap UTC. Contoh `2026-10-03 18:30:45 UTC` tampil `04/10/2026 01:30:45 WIB`, termasuk pada histori yang sudah ada. Urutan waktu tetap berdasarkan timestamp tersimpan. Notifikasi WhatsApp dan penomoran yang sudah memakai WIB tetap sesuai.

## 3. Skenario penerimaan

| ID | Skenario | Hasil |
| --- | --- | --- |
| AC-01 | Admin/FAP aktif menghapus pengaduan Ditolak dari daftar/header edit | Alasan wajib; pengaduan keluar dari daftar aktif dan histori menyimpan identitas penghapus yang benar. |
| AC-02 | FAP mengirim alasan kosong, tipe tidak sesuai, atau terlalu panjang | Ditolak; laporan/file/metadata tidak berubah. |
| AC-03 | Admin/FAP mencoba status Diterima, Investigasi, atau Selesai | Aksi tidak tersedia dan service menolak. |
| AC-04 | FAP menjadi nonaktif atau berubah menjadi Kepala Balai setelah dialog dibuka | Eksekusi ditolak berdasarkan akses terbaru. |
| AC-05 | Akun admin berubah menjadi FAP sebelum service dieksekusi | Tetap diperbolehkan bila aktif; metadata memakai identitas akun terbaru. |
| AC-06 | FAP atau role tanpa hak membuka histori/unduhan | Ditolak; admin/Kepala Balai tetap dapat memeriksa penghapusan oleh FAP. |
| AC-07 | Waktu UTC melewati tengah malam/tahun di WIB | Daftar/detail menampilkan tanggal dan jam WIB yang benar dengan penanda WIB. |
| AC-08 | Waktu lama/belum selesai ditampilkan | UTC asli tidak berubah; waktu null tetap placeholder. |
| AC-09 | Default datetime/tanggal saja Filament ditampilkan | Datetime mengikuti WIB; tanggal saja tidak bergeser. |

## 4. Implementasi dan verifikasi

Rencana: [plan.md](plan.md). Checklist: [tasks.md](tasks.md). Hasil aktual: [verification.md](verification.md). Aktivasi: [deployment.md](deployment.md).

Tidak diperlukan migration, perubahan timezone server/MySQL, atau penulisan ulang timestamp. Penghapusan SQL langsung tetap berada di luar histori aplikasi sesuai keputusan pengguna sebelumnya.

## 5. Referensi

- [Filament 5 — Timezone pada TextColumn](https://filamentphp.com/docs/5.x/tables/columns/text#setting-the-timezone-for-date-formatting): default tampilan melalui `FilamentTimezone::set()`; tanggal tanpa jam tidak dikonversi otomatis.
- [Laravel 13 — Date Casting, Serialization, and Timezones](https://laravel.com/framework/docs/13.x/eloquent-mutators#date-casting-serialization-and-timezones): UTC tetap menjadi dasar penyimpanan timestamp.
