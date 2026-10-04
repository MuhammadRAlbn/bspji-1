# Rencana Implementasi

Tanggal: 4 Oktober 2026 (Asia/Jakarta).

1. Tulis spec dan test penerimaan sebelum perubahan aplikasi. Perbarui test lama yang menganggap FAP aktif tidak boleh menghapus; demosi admin ke FAP kini bukan pencabutan hak hapus.
2. Perluas policy `delete` menjadi admin/FAP aktif. Pertahankan Gate, middleware, izin histori, dan service penghapusan yang sudah memeriksa akun/status terbaru di dalam transaksi.
3. Perbarui deskripsi role FAP, pesan model, dan label snapshot agar berlaku untuk kedua role.
4. Tetapkan default timezone Filament `Asia/Jakarta` di AppServiceProvider. Format waktu pengaduan/histori dengan `d/m/Y H:i:s` dan literal WIB. Aplikasi tetap UTC; tidak ada migration atau backfill.
5. Verifikasi service/form kedua role, validasi, pencabutan akses, identitas FAP di histori, larangan akses histori FAP, rollover tanggal/tahun, raw timestamp UTC, dan perilaku tanggal saja. Periksa juga tanggal publikasi berita: waktu tampil/dimasukkan sebagai WIB dan tersimpan sebagai UTC, termasuk ketika form disimpan tanpa perubahan. Field publikasi menjelaskan penggunaan WIB. Jalankan regresi akses dan suite proyek karena default timezone memengaruhi seluruh datetime Filament.

API dikonfirmasi melalui source Filament 5.4.2 yang terpasang dan dokumentasi resmi Filament 5/Laravel 13. Tidak ada dependensi tambahan atau perubahan aset frontend.
