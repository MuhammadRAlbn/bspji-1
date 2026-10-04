# Aktivasi dan Penggunaan

Implementasi tersedia dalam working tree. Akun operasional dibuat melalui panel.

## 1. Status database dan migration

Pemeriksaan read-only yang dicatat pada 2 Oktober 2026 dengan `php artisan migrate:status` berhasil: MySQL lokal tersedia dan kedua migration fitur awal sudah berstatus **Ran**, batch 74. Pemeriksaan ini hanya membaca status migration. Pengujian otomatis dan preview tetap menggunakan SQLite terpisah.

Pada lingkungan lain yang belum menerapkan migration fitur awal, jalankan database lalu terapkan dua migration dari direktori proyek:

```powershell
php artisan migrate --path=database/migrations/2026_10_02_145627_add_is_active_to_users_table.php --path=database/migrations/2026_10_02_145628_change_default_role_on_users_table.php
```

Migration menambah status aktif dan mengubah default role akun baru menjadi `unassigned`. Akun existing mempertahankan role/password dan mendapat status aktif. Perintah di atas mengasumsikan migration aplikasi sebelumnya sudah diterapkan.

Prasyarat login panel: schema server harus sudah memuat `users.is_active`. Deploy kode baru tanpa migration ini dapat membuat login ditolak walaupun password benar, karena pemeriksaan akses memerlukan akun aktif dengan role valid. Status migration lokal di atas tidak membuktikan migration sudah diterapkan pada server deployment. Periksa dari direktori aplikasi di server sebelum mencoba login:

```shell
php artisan migrate:status
```

Pastikan kedua migration fitur awal berstatus **Ran**. Untuk akun admin existing, nilai `role` harus persis `admin` dan `is_active` bernilai `1`. Perubahan default role tidak mengubah role akun existing.

## 2. Buat akun FAP dan Kepala Balai

1. Login menggunakan akun admin existing.
2. Buka **Administrasi > Manajemen Akun** (`/admin/users`).
3. Pilih **Buat Akun**, isi nama, email, role, status aktif, password minimal 12 karakter (bcrypt maksimal 72 byte), dan konfirmasi password.
4. Buat akun terpisah untuk setiap anggota FAP dan Kepala Balai sesuai identitas yang ditentukan admin.
5. Gunakan **Ubah** untuk mengganti role, mereset password akun lain, atau menonaktifkan akun. Password kosong saat edit mempertahankan password dan sesi lama; reset mencabut sesi/token target. Password sendiri diganti melalui avatar > Ubah Password.
6. Gunakan **Hapus** pada baris daftar atau header **Ubah Akun** untuk menghapus akun lain. Dialog menampilkan nama/email target. Pilih **Batal** untuk mempertahankan akun, atau **Hapus Akun** untuk menghapusnya secara permanen. Aksi tidak tersedia untuk akun sendiri/admin aktif terakhir; penonaktifan tetap tersedia untuk pencabutan akses yang dapat dipulihkan. Penghapusan massal akun tidak disediakan.

Penambahan hapus akun tidak membutuhkan migration baru di luar dua migration fitur awal.

Tidak ada akun operasional atau password bawaan yang dibuat oleh migration. Pengguna tanpa role valid tidak dapat masuk panel; jalur pembuatan akun di luar Manajemen Akun juga harus menetapkan role secara eksplisit.

## 3. Perilaku setelah login

- FAP dan Kepala Balai langsung masuk ke daftar Pengaduan.
- Tombol **Lihat** membuka detail laporan untuk keduanya.
- FAP memperoleh **Ubah** untuk status, hasil tindak lanjut, dan dokumen hasil; delete tidak tersedia.
- Kepala Balai tidak memperoleh form edit/simpan/unggah/delete Pengaduan. Semua role aktif memperoleh menu Ubah Password untuk akun sendiri.
- Admin dapat menghapus pengaduan Ditolak dengan alasan manual; admin/Kepala Balai mendapat Riwayat Penghapusan baca saja sesuai [spec 003](../003-riwayat-penghapusan-pengaduan/spec.md). Hapus massal pengaduan tidak tersedia.
- Akun yang dinonaktifkan kehilangan akses pada permintaan berikutnya. Sesi panelnya dibersihkan sehingga halaman login dapat digunakan kembali.
- Akun yang dihapus hilang dari daftar dan tidak dapat login atau memakai sesi/form/upload lama. Sesi database dan token reset target dibersihkan; konten tetap tersimpan. Setelah hapus dari halaman edit, admin kembali ke daftar akun.
- Humas mempertahankan menu Berita/Komentar dan tidak mendapat akses Pengaduan atau Manajemen Akun.

## 4. Verifikasi ulang bila dibutuhkan

```powershell
php artisan test --compact
```

Test memakai SQLite in-memory sesuai `phpunit.xml`. Hasil terakhir dan batas pengujian ada pada [verification.md](verification.md).

## 5. Pergantian password mandiri

Spec 002 disetujui pada 3 Oktober 2026 dan diimplementasikan. Semua role aktif dapat membuka avatar > Ubah Password, mengisi password saat ini/baru/konfirmasi, lalu Simpan Password. Penggantian opsional, minimum 12 karakter, dan tanpa migration baru. Sesi lama tanpa fingerprint perlu login ulang dengan password yang masih berlaku. Panduan lengkap: [penggunaan spec 002](../002-pergantian-password-mandiri/deployment.md); hasil regresi terbaru: [verifikasi spec 002](../002-pergantian-password-mandiri/verification.md).

## 6. Riwayat penghapusan pengaduan

Spec 003 menambah migration metadata/soft delete pengaduan. Migration telah diterapkan pada MySQL development lokal. Panduan lingkungan lain, alur alasan manual, serta akses Kepala Balai ada pada [penggunaan spec 003](../003-riwayat-penghapusan-pengaduan/deployment.md); hasil pengujian pada [verifikasi spec 003](../003-riwayat-penghapusan-pengaduan/verification.md).

## 7. Pemeriksaan login setelah deploy

Panduan diperjelas pada 4 Oktober 2026 setelah laporan login server dengan migration yang belum diterapkan.

Pesan email/password tidak cocok dari Filament dapat berarti kredensial salah **atau** akun tidak memenuhi izin masuk panel. Periksa status migration, keberadaan akun pada database yang dipakai server, role, dan status aktif sebelum mereset password. Minimum 12 karakter berlaku pada pembuatan/penggantian password baru, bukan login memakai password existing.

Jika login sempat berhasil lalu kembali ke halaman login, periksa persistensi sesi/cookie dan konfigurasi deployment sesuai [panduan spec 002](../002-pergantian-password-mandiri/deployment.md). Sesi sebelum pembaruan dapat memerlukan login ulang; jangan mengganti `APP_KEY` untuk memperbaiki login.
