# Rencana Zona Integritas Dinamis

## Summary
Ya, memungkinkan dan saya rekomendasikan: buat satu domain besar **Zona Integritas**, dengan satu tabel dokumen yang dibedakan oleh `jenis_dokumen_id`. Konten gambar IKM sebaiknya tabel terpisah karena perilakunya berbeda dari dokumen PDF.

## Key Changes
- Ganti section statis di [welcome.blade.php](/C:/laragon/www/bspji-1/resources/views/welcome.blade.php:939) menjadi komponen Blade khusus, misalnya `<x-zona-integritas.section />`, dengan Alpine untuk klik 7 logo dan tab internal.
- Tambah tabel master `zona_integritas_jenis_dokumens` berisi kode tetap:
  `zona-integritas`, `ikm-laporan`, `indeks-persepsi-korupsi`, `benturan-kepentingan`, `benturan-laporan`, `gratifikasi-laporan`, `wbs-laporan`.
- Tambah tabel `zona_integritas_dokumens`:
  `id`, `jenis_dokumen_id`, `nama_dokumen`, `file_path`, `urutan`, `is_active`, timestamps.
- Tambah tabel `zona_integritas_grafik_ikms`:
  `id`, `judul`, `gambar`, `urutan`, `is_active`, timestamps.

## Filament Admin
- Buat cluster/resource Filament **Zona Integritas**.
- Resource **Dokumen Zona Integritas** mengelola semua PDF dengan pilihan `Jenis Dokumen`.
- Resource **Grafik IKM** hanya untuk gambar tab grafik IKM.
- Upload PDF dibatasi `application/pdf`; upload gambar memakai `FileUpload::image()` mengikuti pola resource yang sudah ada.

## Frontend Behavior
- 7 logo tetap satu section besar “Zona Integritas”; klik logo menampilkan konten inline di bawah logo.
- Pengaduan dibuat placeholder/diabaikan dulu, tanpa database.
- Konten statis seperti paragraf dan Google Form tetap di Blade/component.
- Semua tombol download memakai satu route, misalnya `zona-integritas.dokumen.download`, dengan validasi file aktif dan file tersedia.

## Test Plan
- Jalankan migration dan pastikan jenis dokumen terseed.
- Cek CRUD Filament: tambah PDF tiap jenis, tambah gambar IKM, ubah urutan, nonaktifkan item.
- Cek beranda: logo berpindah konten, tab internal jalan, gambar IKM tampil, tabel download sesuai jenis.
- Cek download: file PDF berhasil diunduh, dokumen nonaktif atau file hilang menghasilkan 404.

## Assumptions
- `jenis_dokumen_id` memakai tabel master agar rapi; kode/slug dipakai di query, bukan angka ID hardcoded.
- Gambar IKM tidak digabung ke tabel dokumen.
- Google Form dan paragraf statis akan diisi langsung di komponen Blade.
