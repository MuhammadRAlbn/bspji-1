# Aktivasi

Perubahan memakai schema riwayat dari spec 003. Tidak ada migration baru, perubahan `.env`, atau perubahan timezone server/MySQL.

Deploy source sesuai prosedur proyek. Bila environment menggunakan cache konfigurasi/view/opcache atau worker yang berjalan lama, perbarui cache/restart proses sesuai prosedur deployment yang sudah digunakan. `config/app.php` tetap UTC; WIB diterapkan pada tampilan Filament melalui AppServiceProvider.

FAP aktif dapat menghapus pengaduan Ditolak dari tombol Hapus pada daftar atau edit dengan alasan wajib. Admin/Kepala Balai melihat histori dengan identitas penghapus FAP. FAP tetap tidak mendapat menu/unduhan histori. Tanggal/jam pengaduan dan histori menampilkan WIB, termasuk record lama.

Timestamp SQL mentah tetap UTC. Tidak perlu menjalankan update `+7 jam` pada tabel; konversi sudah dilakukan saat ditampilkan.
