# Aktivasi dan Penggunaan

Implementasi tersedia dalam working tree. Akun operasional dibuat melalui panel.

## 1. Status database dan migration

Pemeriksaan terbaru dengan `php artisan migrate:status` berhasil: MySQL lokal tersedia dan kedua migration fitur awal sudah berstatus **Ran**, batch 74. Pemeriksaan ini hanya membaca status migration. Pengujian otomatis dan preview tetap menggunakan SQLite terpisah.

Pada lingkungan lain yang belum menerapkan migration fitur awal, jalankan database lalu terapkan dua migration dari direktori proyek:

```powershell
php artisan migrate --path=database/migrations/2026_10_02_145627_add_is_active_to_users_table.php --path=database/migrations/2026_10_02_145628_change_default_role_on_users_table.php
```

Migration menambah status aktif dan mengubah default role akun baru menjadi `unassigned`. Akun existing mempertahankan role/password dan mendapat status aktif. Perintah di atas mengasumsikan migration aplikasi sebelumnya sudah diterapkan.

## 2. Buat akun FAP dan Kepala Balai

1. Login menggunakan akun admin existing.
2. Buka **Administrasi > Manajemen Akun** (`/admin/users`).
3. Pilih **Buat Akun**, isi nama, email, role, status aktif, password minimal 12 karakter, dan konfirmasi password.
4. Buat akun terpisah untuk setiap anggota FAP dan Kepala Balai sesuai identitas yang ditentukan admin.
5. Gunakan **Ubah** untuk mengganti role/password atau menonaktifkan akun. Password kosong saat edit mempertahankan password lama.
6. Gunakan **Hapus** pada baris daftar atau header **Ubah Akun** untuk menghapus akun lain. Dialog menampilkan nama/email target. Pilih **Batal** untuk mempertahankan akun, atau **Hapus Akun** untuk menghapusnya secara permanen. Aksi tidak tersedia untuk akun sendiri/admin aktif terakhir; penonaktifan tetap tersedia untuk pencabutan akses yang dapat dipulihkan. Penghapusan massal akun tidak disediakan.

Penambahan hapus akun tidak membutuhkan migration baru di luar dua migration fitur awal.

Tidak ada akun operasional atau password bawaan yang dibuat oleh migration. Pengguna tanpa role valid tidak dapat masuk panel; jalur pembuatan akun di luar Manajemen Akun juga harus menetapkan role secara eksplisit.

## 3. Perilaku setelah login

- FAP dan Kepala Balai langsung masuk ke daftar Pengaduan.
- Tombol **Lihat** membuka detail laporan untuk keduanya.
- FAP memperoleh **Ubah** untuk status, hasil tindak lanjut, dan dokumen hasil; delete tidak tersedia.
- Kepala Balai tidak memperoleh form edit/simpan/unggah/delete.
- Akun yang dinonaktifkan kehilangan akses pada permintaan berikutnya. Sesi panelnya dibersihkan sehingga halaman login dapat digunakan kembali.
- Akun yang dihapus hilang dari daftar dan tidak dapat login atau memakai sesi/form/upload lama. Sesi database dan token reset target dibersihkan; konten tetap tersimpan. Setelah hapus dari halaman edit, admin kembali ke daftar akun.
- Humas mempertahankan menu Berita/Komentar dan tidak mendapat akses Pengaduan atau Manajemen Akun.

## 4. Verifikasi ulang bila dibutuhkan

```powershell
php artisan test --compact
```

Test memakai SQLite in-memory sesuai `phpunit.xml`. Hasil terakhir dan batas pengujian ada pada [verification.md](verification.md).
