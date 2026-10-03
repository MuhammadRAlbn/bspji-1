# Aktivasi dan Penggunaan: Riwayat Penghapusan Pengaduan

Tanggal: 3 Oktober 2026 (Asia/Jakarta). Implementasi tersedia. Hasil aktual: [verification.md](verification.md).

## 1. Migration

Migration `2026_10_03_104257_add_deletion_history_to_zona_integritas_pengaduans_table.php` telah diterapkan pada MySQL development lokal. Migration hanya menambah kolom/indeks; pengaduan existing tetap aktif, dengan metadata penghapusan kosong. Tidak ada akun atau pengaduan operasional yang dihapus saat aktivasi.

Pada lingkungan lain, deploy source dan terapkan migration sebelum menerima request aplikasi yang memakai SoftDeletes:

```powershell
php artisan migrate --path=database/migrations/2026_10_03_104257_add_deletion_history_to_zona_integritas_pengaduans_table.php
```

Ikuti proses backup dan cache deployment lingkungan tersebut. Tidak ada dependency Composer/npm baru atau build frontend baru untuk fitur ini. Jangan melakukan rollback kolom setelah ada histori tanpa rencana pemeliharaan data; down menghilangkan metadata penghapusan. Histori ini berlaku sejak fitur diaktifkan dan tidak memulihkan pengaduan yang sebelumnya telah dihapus permanen.

## 2. Penghapusan oleh admin

1. Buka **Zona Integritas > Pengaduan** (`/admin/zona-integritas/zona-integritas-pengaduans`).
2. Tindak lanjuti laporan menggunakan alur existing. Penghapusan tersedia hanya saat status **Pengaduan ditolak**.
3. Pilih **Hapus** pada baris atau header halaman edit.
4. Isi **Alasan Penghapusan** secara manual, maksimal 2.000 karakter, untuk menjelaskan penolakan dan penghapusan dari daftar.
5. Pilih **Hapus Pengaduan**. Pengaduan keluar dari daftar aktif dan tersimpan di riwayat dengan identitas admin serta waktu penghapusan. Pilih **Batal** untuk mempertahankannya.

Penghapusan massal tidak tersedia. Pengaduan pada status Diterima/Investigasi/Selesai tidak memiliki aksi hapus yang dapat dijalankan.

## 3. Memeriksa histori

Admin dan Kepala Balai membuka **Zona Integritas > Riwayat Penghapusan** (`/admin/zona-integritas/riwayat-penghapusan-pengaduans`). Cari nomor, judul, nama admin, atau alasan. Pilih **Lihat** untuk membaca alasan lengkap, identitas admin saat penghapusan, laporan, tindak lanjut, serta lampiran yang masih tersedia.

Riwayat tidak menyediakan perubahan atau pemulihan. Pergantian nama/email atau penghapusan akun admin pelaku tidak mengubah catatan identitas saat penghapusan. FAP/Humas tidak dapat mengakses riwayat atau mengunduh lampirannya.

Pengaduan terhapus tidak tersedia melalui pelacakan publik dan URL unduhan existing. Unduhan riwayat selalu memakai sesi aktif dan izin admin/Kepala Balai. Jika file aslinya tidak ada, unduhan memberi 404; fitur ini tidak membuat ulang file yang hilang.

## 4. Verifikasi ulang

```powershell
php artisan test --compact tests/Feature/Filament/ZonaIntegritas/PengaduanDeletionHistoryTest.php
php artisan test --compact
```

Test memakai SQLite in-memory. Preview browser memakai database/akun/file dummy terpisah. Konkurensi dua transaksi MySQL paralel dan perubahan lewat SQL langsung bukan hasil yang diklaim diuji oleh suite SQLite.
