# Hasil Verifikasi

Tanggal: 4 Oktober 2026 (Asia/Jakarta). Status: **implementasi selesai; 338 test lulus, 2.507 assertion, tanpa kegagalan (515,59 detik)**.

## Urutan pengembangan

1. Spesifikasi, rencana, checklist, dan aktivasi ditulis sebelum test serta perubahan aplikasi. Pembatasan histori FAP pada baseline 003/004 ditandai sebagai keputusan historis yang diperbarui oleh spec 005.
2. Test pembaca/akun terlarang diperluas, ditambah alur FAP menghapus lalu membaca histori sendiri serta penghapusan admin. Test pencabutan akses Kepala Balai menjadi FAP diperbarui: transisi ini kini sah, sedangkan perubahan menjadi Humas/nonaktif tetap ditolak.
3. Test penerimaan baru dijalankan sebelum implementasi: **1 gagal, 7 assertion, 87,54 detik**. Penghapusan FAP berhasil, tetapi GET daftar riwayat mendapat **403**, sesuai masalah yang dilaporkan pengguna.
4. Policy menambahkan FAP aktif sebagai pembaca histori. Gate staf pengaduan dan middleware rute histori diselaraskan; deskripsi role FAP diperbarui. Query, schema, endpoint dokumen, dan aturan mutasi tidak memerlukan perubahan.
5. Laravel Pint dan pemeriksaan format final pada enam file PHP yang diubah: **pass**. Regresi lengkap dijalankan sesudah perubahan PHP final.
6. Suite regresi final: **338 test lulus, 2.507 assertion, 515,59 detik**. `git diff --check` bersih. Baseline 332 test/2.434 assertion pada spec 004 tetap merupakan hasil historis sebelum pembaruan izin baca histori ini.

## Cakupan

| Perilaku | Pengujian |
| --- | --- |
| FAP membaca histori sendiri sesudah hapus | `test_fap_can_read_its_own_history_and_admin_deletions_after_deleting_a_complaint`: aksi Hapus, daftar/detail, identitas/alasan, komponen detail, lampiran. |
| Menu tampil dan seluruh aktor dapat diperiksa | Halaman pengaduan FAP menampilkan Riwayat Penghapusan; histori admin dibaca dalam alur baru, histori FAP lain dibaca melalui provider pembaca. |
| Seluruh pembaca sah | `historyReaders`: admin, Kepala Balai, FAP; HTTP daftar/detail, pencarian, escaping, dan kedua dokumen. |
| Histori tetap hanya dapat dibaca | Provider pembaca juga memeriksa `canCreate/canEdit/canDelete/canDeleteAny/canRestore/canForceDelete` semuanya false dan halaman hanya index/view. Test model tetap menolak mutasi/restore/force delete. |
| Akun terlarang | Humas, role invalid, serta admin/FAP/Kepala Balai nonaktif: resource, HTTP, komponen daftar/detail, dan unduhan ditolak. Tamu perlu login. |
| Akses terbaru setelah mount | Kepala Balai menjadi Humas, FAP menjadi Humas, serta FAP dinonaktifkan: refresh daftar/detail dan kedua dokumen ditolak. Snapshot autentikasi lama diuji secara terpisah pada setiap jalur. |
| Transisi role pembaca yang sah | Kepala Balai menjadi FAP: halaman yang sudah terbuka serta kedua unduhan tetap dapat diakses. |
| Resource lain tetap dibatasi | `PengaduanAccessTest` mengizinkan dua resource untuk FAP/Kepala Balai; seluruh resource lain tetap ditolak. |
| Regresi lama | Soft delete, alasan wajib, status Ditolak, snapshot pelaku, file retention, sesi akun, WIB, berita, dan fitur proyek lainnya. |

## Lingkungan dan perintah

```powershell
php artisan test --compact --filter=test_fap_can_read_its_own_history_and_admin_deletions_after_deleting_a_complaint
php vendor/bin/pint --test app/Policies/ZonaIntegritasPengaduanPolicy.php app/Providers/AppServiceProvider.php app/Http/Middleware/EnsureAdminPanelAccess.php app/Models/User.php tests/Feature/Filament/ZonaIntegritas/PengaduanDeletionHistoryTest.php tests/Feature/Filament/ZonaIntegritas/PengaduanAccessTest.php
php artisan test --compact
git diff --check
```

Test menggunakan SQLite in-memory, sesi/cache sementara, dan filesystem palsu sesuai `phpunit.xml`. Proses PHP memakai izin eksekusi yang sesuai karena batas ACL sandbox Windows sudah diketahui. Tidak ada pengubahan pengaduan, akun, atau lampiran MySQL operasional; tidak ada migration baru.

Pemeriksaan tampilan memakai respons HTTP dan komponen Livewire otomatis. Tidak ada screenshot browser baru untuk perubahan ini.
