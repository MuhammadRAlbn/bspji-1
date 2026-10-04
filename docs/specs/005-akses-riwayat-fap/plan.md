# Rencana Implementasi

1. Tambahkan test penerimaan FAP: menu, hapus lalu baca histori sendiri, baca penghapusan admin/FAP lain, dan kedua dokumen. Perluas provider pembaca/akun terlarang, serta pencabutan akses setelah mount. Konfirmasi test baru gagal sebelum perubahan aplikasi.
2. Policy `viewHistoryAny` memasukkan FAP aktif. Gate staf pengaduan meneruskan `viewHistoryAny/viewHistory` ke policy untuk kedua role staf. Middleware panel mengizinkan wildcard resource histori untuk kedua role staf.
3. Pertahankan query `onlyTrashed`, halaman daftar/detail, endpoint unduhan, dan larangan mutasi yang sudah ada. Perbarui deskripsi role FAP.
4. Jalankan format PHP dan suite regresi proyek. Catat hasil aktual; beri tautan perubahan terbaru pada baseline spec sebelumnya tanpa menghapus keputusan historis.

Skill Laravel telah digunakan untuk audit keamanan/pola existing. Tidak ada API library baru atau dependensi tambahan.
