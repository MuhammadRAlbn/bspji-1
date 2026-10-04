# Hasil Verifikasi

Tanggal: 4 Oktober 2026 (Asia/Jakarta). Status: **implementasi selesai; suite proyek lulus 332 test, 2.434 assertion, tanpa kegagalan (220,54 detik)**.

## Urutan Spec Driven Development

1. Permintaan pengguna memperluas hak hapus ke FAP dan meminta tanggal/jam WIB. Spec, rencana, checklist, dan aktivasi ditulis sebelum perubahan aplikasi.
2. Test penghapusan diperluas untuk admin/FAP, termasuk dialog daftar/edit, validasi alasan, status, pencabutan akses, snapshot identitas, dan akses histori. Test timezone menambahkan rollover tanggal/tahun serta pengecekan UTC asli.
3. Test awal dijalankan sebelum implementasi: **2 gagal, 1 lulus, 31 assertion, 46,72 detik**. Kegagalan sesuai perilaku lama: penghapusan FAP ditolak (`AuthorizationException`) dan default timezone Filament masih UTC. Kasus admin tetap lulus.
4. Implementasi memperluas policy, memperbarui teks pelaku, menetapkan default timezone Filament Asia/Jakarta, dan memformat waktu pengaduan/histori dengan penanda WIB. Service transaksi, penyimpanan UTC, serta izin histori tetap menggunakan mekanisme yang ada.
5. Pengujian terarah pertama: **94 lulus, 2 gagal, 815 assertion, 177,01 detik**. Dua kegagalan berasal dari test komponen Filament tanpa konteks schema/Livewire. Test kemudian memakai halaman Livewire yang sebenarnya.
6. Regresi tambahan memeriksa input tanggal publikasi berita karena timezone default juga berlaku pada DateTimePicker. Setelah perbaikan konteks test, pemeriksaan tiga skenario tersebut: **3 lulus, 17 assertion, 12,05 detik**.
7. Suite proyek setelah seluruh perubahan PHP dan Pint: **332 lulus, 2.434 assertion, 220,54 detik**. Seluruh skenario penerimaan dan regresi fitur lama lulus. Baseline 306 test/2.248 assertion pada spec 003 merupakan hasil historis sebelum perubahan ini.

## Cakupan

| Perilaku | Bukti otomatis |
| --- | --- |
| Admin/FAP aktif menghapus Ditolak dengan metadata server | `PengaduanDeletionHistoryTest`: kedua role, input spoof, file/laporan asli. |
| Alasan wajib dan batas 2.000 karakter | Kedua role diuji dengan kosong, whitespace Unicode, array, dan teks terlalu panjang. |
| Status lain/akun tanpa hak ditolak | Diterima/Investigasi/Selesai, FAP nonaktif, Kepala Balai, Humas, role invalid. |
| Daftar/header edit | Kedua role menjalankan dialog, cancel, validasi kosong, hapus berhasil, dan snapshot identitas. |
| Pemeriksaan akses terbaru | Dialog FAP nonaktif/FAP menjadi Kepala Balai ditolak; perubahan admin menjadi FAP tetap diizinkan dengan identitas terbaru. |
| Histori penghapusan FAP dapat diperiksa | Admin/Kepala Balai membaca nama/email/alasan FAP dengan escaping. FAP tetap ditolak pada menu/URL/komponen/unduhan. |
| WIB pada data lama dan baru | `PengaduanWibTimezoneTest`: HTTP daftar/detail pengaduan/histori, rollover tengah malam dan tahun baru, seluruh raw timestamp tetap UTC. |
| Null dan tanggal tanpa jam | Field selesai dari infolist asli mempertahankan placeholder; tanggal saja tidak berubah hari karena timezone. |
| Urutan histori/notifikasi | Urutan lama-baru tetap benar saat melewati tengah malam WIB; WhatsApp tetap menunjukkan WIB pada tahun baru. |
| Input datetime panel lainnya | `NewsResourceTest`: UTC tampil sebagai WIB; simpan tanpa perubahan mempertahankan UTC; perubahan jam WIB dikonversi kembali ke UTC. |
| Fitur lama | Suite proyek mencakup akses akun/sesi, upload/download, tindak lanjut, pelacakan publik, berita, dan fitur lainnya. |

## Perintah dan lingkungan

```powershell
php artisan test --compact --filter='test_authorized_deletion_preserves_the_report_files_and_server_generated_history|test_filament_default_datetime_uses_wib_while_date_only_keeps_its_date'
php artisan test --compact --filter='PengaduanDeletionHistoryTest|PengaduanWibTimezoneTest|PengaduanAccessTest'
php artisan test --compact --filter='test_filament_default_datetime_uses_wib_while_date_only_keeps_its_date|test_unfinished_complaints_keep_a_placeholder_for_completion_time|test_publication_time_round_trips_between_wib_input_and_utc_storage'
php artisan test --compact
git diff --check
```

PHP 8.3, Laravel 13, Filament 5.4.2. Test memakai konfigurasi `phpunit.xml`: SQLite in-memory dan sesi/cache test. Proses PHP memakai izin eksekusi yang sesuai karena batas ACL sandbox Windows telah diketahui pada sesi sebelumnya. Tidak ada perubahan akun/pengaduan atau timestamp MySQL operasional. Tidak ada migration baru.

Laravel Pint pada seluruh 11 file PHP yang diubah: **pass**. `git diff --check`: **bersih**. Pemeriksaan tampilan memakai respons HTTP/komponen Livewire otomatis; tidak ada screenshot browser baru untuk perubahan ini.
