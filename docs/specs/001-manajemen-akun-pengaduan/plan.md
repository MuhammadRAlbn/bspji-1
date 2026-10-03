# Rencana Teknis: Manajemen Akun dan Akses Pengaduan

Acuan: [spec.md](spec.md). Status: Implementasi termasuk FR-11 selesai diverifikasi; baseline setelah FR-11 lulus 224 test (1.626 assertion). Hasil pada [verification.md](verification.md).

## 1. Pendekatan

Pertahankan satu panel Filament `admin` dan kolom `users.role`. Tambahkan konstanta/helper role FAP dan Kepala Balai, status akun aktif, policy Pengaduan, serta policy User. Izin tetap dalam kode sesuai D-01; tahap ini tidak memerlukan tabel role/permission atau paket tambahan.

Gunakan pola aplikasi yang ada. Jangan membuat panel terpisah hanya untuk dua role baru. Hindari `Gate::before` yang mengizinkan seluruh aksi admin tanpa memeriksa policy karena policy existing juga memuat batas bisnis, misalnya jumlah record tunggal.

## 2. Data akun dan migrasi

- Migration baru menambah `users.is_active` dengan default aktif sehingga akun existing tetap dapat masuk.
- Migration baru mengubah default `users.role` menjadi nilai nonprivileged, misalnya `unassigned`. Model memakai default yang sama; nilai tersebut tidak termasuk role panel yang valid.
- Form admin wajib menetapkan role valid. Akun existing tidak ditulis ulang/didemote; tidak ada backfill identitas atau password.
- Factory pengujian menyebutkan role admin secara eksplisit dan menyediakan state FAP, Kepala Balai, Humas, serta nonaktif sesuai kebutuhan test.
- Migration lama yang telah digunakan tetap utuh. `down()` mengembalikan perubahan schema; rollback default lama merupakan rollback teknis, bukan pilihan untuk deployment fitur ini.

## 3. Akses panel dan pembatasan resource

`User::canAccessPanel()` memeriksa panel yang dituju, status aktif, dan role valid. Tambahkan pembatasan FAP/Kepala Balai dalam mekanisme otorisasi terpusat yang sudah menggunakan `Gate::before`:

1. Akun nonaktif atau role tidak valid ditolak pada akses internal.
2. Untuk FAP/Kepala Balai, model selain Pengaduan ditolak secara default.
3. Untuk model Pengaduan, kembalikan pemeriksaan ke `ZonaIntegritasPengaduanPolicy`; jangan mengizinkan semua kemampuan model tersebut sekaligus.
4. Pertahankan pembatasan Humas pada berita/komentar.
5. Admin mengikuti policy dan batas resource existing.

Periksa kemampuan/gate tanpa argumen model secara tersendiri. Gate berbasis model tidak cukup untuk dashboard, custom page, widget, atau custom action. Inventaris resource/page dan uji semua akses yang tersedia; perhatikan resource yang meng-override `canCreate()` atau aksi lainnya.

Implementasi memakai whitelist kemampuan Pengaduan pada Gate, middleware panel persistent, dan pemeriksaan ulang pada hydrate komponen terkait. Middleware panel memperbarui data akun sebelum otorisasi dan membersihkan sesi akun yang kehilangan akses. Middleware upload sementara menolak Kepala Balai/nonaktif dan mempertahankan upload Admin/Humas/FAP.

Tidak langsung mengaktifkan `strictAuthorization()` secara global: banyak model belum mempunyai policy lengkap. Pembatasan role harus tetap menolak resource yang belum mempunyai policy; mengaktifkan mode strict memerlukan audit policy terpisah agar admin existing tidak mengalami error.

## 4. Policy dan batas penyimpanan

`ZonaIntegritasPengaduanPolicy`:

- `viewAny`/`view`: admin, FAP, Kepala Balai yang aktif.
- `update`: admin dan FAP yang aktif.
- `delete`/`deleteAny`: admin aktif, mengikuti kemampuan Pengaduan yang ada.
- `create`: false, karena tahap ini tidak menyediakan pembuatan laporan dari panel.
- Kemampuan lain yang tidak dipakai, seperti replicate/restore/force delete, tidak diberi akses kepada role baru.

`UserPolicy`: seluruh kemampuan Manajemen Akun terbatas pada admin aktif. `delete` melarang akun sendiri dan admin aktif terakhir; `deleteAny` tetap false. `UserManagementService::delete()` memeriksa actor/target terbaru dalam transaksi dengan query lock seluruh admin serta actor/target, diurutkan menurut ID, sama seperti `update()`. Guard perubahan/penghapusan mempertahankan admin aktif dan melarang penonaktifan/demotion/delete diri sendiri.

Penghapusan permanen dilakukan melalui service, termasuk pada aksi Filament. Hapus token reset password melalui broker aplikasi dan sesi target melalui connection/table sesi yang dikonfigurasi bila driver database. Tidak ada cascade konten: schema tidak memiliki FK ownership akun ke konten. Pemeriksaan sesi/hydrate memakai `fresh()` dan menangani actor yang telah dihapus secara eksplisit, bukan melempar error `refresh()` pada record yang hilang. Tidak ada migration tambahan untuk FR-11.

Penyimpanan tindak lanjut memeriksa policy update dan hanya menerima field tindak lanjut. Validasi status memakai daftar status model. Metadata file dihasilkan server; path yang sudah tersimpan harus milik record tersebut, atau berasal dari upload valid pada alur ini. Hindari menerima arbitrary path dari payload form.

Gunakan service/action khusus bila logika pengubahan akun atau file membutuhkan pemusatan aturan. Pertahankan validasi penyelesaian pada model dan perbaiki penanganan dokumen yang dihapus bila test AC-10 menunjukkan celah. Jangan hanya mengandalkan field `disabled()`.

## 5. Antarmuka Filament

- Resource baru mengikuti struktur `app/Filament/Resources` untuk **Manajemen Akun**, dengan halaman daftar, tambah, dan edit.
- Role select berisi Admin, Humas, FAP, Kepala Balai serta ringkasan izin baca saja. Email unik mempertimbangkan record saat edit; password opsional saat edit.
- Status aktif tidak memakai inline toggle yang melewati guard penyimpanan akun.
- Aksi Hapus pada daftar dan header edit memakai satu `DeleteUserAction` dengan konfirmasi nama/email, penjelasan permanen, dan callback service. Header edit kembali ke daftar sesudah penghapusan. Tidak ada bulk delete akun.
- Tambah `ViewZonaIntegritasPengaduan` dan skema infolist baca saja; daftarkan route detail pada resource existing.
- Kepala Balai menggunakan aksi Lihat; FAP/admin dapat memakai Lihat dan Edit. Delete/header delete/bulk delete mengikuti policy.
- Atur login response/tujuan awal untuk FAP/Kepala Balai, termasuk ketika tujuan tersimpan sebelumnya adalah halaman terlarang. `/admin` mengalihkan keduanya ke Pengaduan.
- Dashboard/page umum dan widget tidak tersedia bagi FAP/Kepala Balai. Navigasi cluster mengikuti resource yang diizinkan sehingga hanya Pengaduan tampil dalam Zona Integritas.

## 6. Endpoint dokumen

`downloadBukti` memeriksa izin `view` terhadap record sebelum membuka file. Pastikan tamu diarahkan ke login Filament karena route bukti berada di luar middleware panel. Periksa status aktif pada policy juga; middleware `auth` saja tidak cukup.

`downloadHasil` publik dan pelacakan tetap mengikuti baseline. Jangan menambahkan pemeriksaan login pada endpoint ini tanpa perubahan spec publik. Jika kelak diperlukan hasil khusus internal, gunakan endpoint/permission tersendiri dan tentukan dokumen mana yang dipublikasikan.

## 7. Rencana verifikasi

| Kelompok test | Cakupan |
| --- | --- |
| Akun | AC-01–AC-03, AC-13, AC-14; validasi, hash password, password edit kosong, role eksplisit, aktif/nonaktif, proteksi admin. |
| Hapus akun | AC-17–AC-19; konfirmasi/batal, aksi daftar/header, service, self/last admin, actor/target stale, sesi/reset token, login/form/upload sesudah delete, dan konten tetap ada. |
| Panel dan navigasi | AC-04–AC-05; tujuan login, dashboard, seluruh resource terdaftar, URL langsung, cluster, dan resource tanpa policy. |
| Pengaduan Filament | AC-06–AC-11; detail, form FAP, read-only Kepala Balai, payload terlarang, custom/bulk action, file, serta penyelesaian. |
| Perubahan akses saat sesi berjalan | AC-12; deactivation dan pergantian role saat komponen sudah terbuka. |
| Unduhan | AC-15; HTTP guest/aktif/nonaktif/role lain, dokumen valid, dan file hilang. |
| Regression | AC-16; NewsResourceTest, SPM/resource yang terdampak Gate, ZonaIntegritasPengaduanTest, serta unduhan/pelacakan publik. |

Ikuti PHPUnit dan pola `RefreshDatabase` repository dengan SQLite in-memory pada `phpunit.xml`. Gunakan Livewire test untuk aksi, bukan hanya memanggil helper role. Pastikan fake storage/queue/HTTP dan fixtures tidak mengirim notifikasi sungguhan. Jalankan suite terkait lebih dahulu, lalu suite proyek setelah perubahan Gate selesai. Jalankan Pint pada PHP yang berubah dan periksa UI menggunakan akun fixture pada lingkungan uji yang terisolasi.

## 8. Titik perubahan yang diperkirakan

`app/Models/User.php`, migration baru, factory User, `app/Providers/AppServiceProvider.php`, konfigurasi/response login dan dashboard panel, resource/policy User baru, policy Pengaduan baru, resource dan halaman Pengaduan, controller unduhan bukti, serta feature tests terkait.

Nama file baru dan rincian API ditentukan saat implementasi berdasarkan Filament 5.4.2 yang terpasang. Perubahan Pengujian/Sertifikasi yang telah ada dalam working tree merupakan pekerjaan lain dan tidak termasuk fitur ini.

## 9. Dasar teknis

Filament memisahkan [akses panel](https://filamentphp.com/docs/5.x/users/overview#authorizing-access-to-the-panel) dari [otorisasi operasi resource dan custom action](https://filamentphp.com/docs/5.x/advanced/security#authorization). Laravel menyediakan [policies dan gates](https://laravel.com/framework/docs/13.x/authorization) untuk memusatkan aturan tersebut.

Perilaku fallback resource tanpa policy juga diperiksa pada source lokal `vendor/filament/filament/src/helpers.php`: dalam konfigurasi non-strict, penolakan eksplisit dari Gate dibutuhkan untuk mencegah akses role baru.

## 10. Integrasi spec 002 (3 Oktober 2026)

Pergantian password mandiri sudah disetujui dan diimplementasikan. Manajemen Akun mereset hanya akun lain; admin sendiri memakai Ubah Password. Rule bcrypt 72 byte, revokasi sesi/token reset admin, dan pemeriksaan fingerprint persistent pada panel/Livewire/upload/bukti mengikuti [rencana spec 002](../002-pergantian-password-mandiri/plan.md). Semua role aktif memperoleh halaman password sendiri tanpa memperluas izin bisnis. Hasil regresi terbaru ada pada [verifikasi spec 002](../002-pergantian-password-mandiri/verification.md).
