# Spesifikasi: Manajemen Akun dan Akses Pengaduan

Tanggal awal: 2 Oktober 2026; diperbarui 3 Oktober 2026 (Asia/Jakarta)

Status: Disetujui pengguna, termasuk klarifikasi halaman detail internal pada FR-06 dan penambahan hapus akun pada FR-11.

Tahap saat ini: Implementasi termasuk hapus akun telah diverifikasi. Baseline setelah FR-11 ialah 224 test (1.626 assertion); setelah spec 002 ialah 261 test (1.997 assertion). Spec 003 menambah histori penghapusan pengaduan; suite proyek terbaru lulus 306 test (2.248 assertion), dicatat pada [verifikasi spec 003](../003-riwayat-penghapusan-pengaduan/verification.md). Dua migration fitur awal dan migration spec 003 telah Ran pada MySQL lokal; hapus akun dan spec 002 tidak menambah migration.

## 1. Tujuan

Admin dapat membuat akun pribadi untuk tim FAP dan Kepala Balai. Kedua role hanya dapat mengakses fitur bisnis Pengaduan pada panel admin, ditambah Ubah Password milik sendiri sesuai spec 002. FAP dapat menindaklanjuti pengaduan; Kepala Balai dapat membaca daftar, detail, dan dokumennya.

Target menu yang sudah ada: `/admin/zona-integritas/zona-integritas-pengaduans`.

## 2. Keputusan yang dikonfirmasi pengguna

| ID | Keputusan |
| --- | --- |
| D-01 | Tahap pertama memakai role bawaan. Admin memilih role akun; izin masing-masing role ditetapkan dalam kode. |
| D-02 | FAP hanya boleh mengubah status, hasil tindak lanjut, dan dokumen hasil. FAP tidak boleh menghapus pengaduan atau mengubah laporan asli. |
| D-03 | Admin dapat menghapus akun lain secara permanen setelah konfirmasi. Akun sendiri dan admin aktif terakhir dilindungi. Dokumen diperbarui mengikuti perilaku terbaru. |

Pengguna telah menyetujui ketiga dokumen spesifikasi dan menjelaskan persetujuan terhadap halaman Lihat Pengaduan sebagai halaman detail di dalam resource existing. Persyaratan dan asumsi di bawah menjadi cakupan implementasi tahap pertama.

## 3. Kondisi aplikasi sebelum implementasi

Tabel ini mencatat baseline peninjauan awal, bukan kondisi fitur setelah implementasi. Perilaku terkini mengikuti persyaratan di bawah dan [verification.md](verification.md).

| Bagian | Kondisi saat peninjauan |
| --- | --- |
| Versi dalam `composer.lock` | Laravel 13.2.0, Filament 5.4.2, Livewire 4.2.2. |
| Akun | `app/Models/User.php` sudah memiliki role `admin` dan `humas`, pemeriksaan akses panel, serta cast password `hashed`. |
| Default role | Model dan migration role memberi default `admin`. Akun baru tanpa pilihan role berpotensi mendapat akses admin. |
| Pembatasan Humas | `app/Providers/AppServiceProvider.php` memakai `Gate::before` untuk membatasi resource model ke berita dan komentar berita. |
| Manajemen akun | Belum ditemukan resource Filament untuk membuat akun, mengganti role, atau menonaktifkan akun. |
| Pengaduan | Resource menyediakan daftar dan edit; belum memiliki halaman detail khusus maupun policy pengaduan. |
| Form pengaduan | Laporan asli sudah tidak dapat diedit melalui form. Field tindak lanjut ialah `status`, `hasil_teks`, dan `dokumen_hasil_path`. |
| Penghapusan | Delete pada baris, header edit, dan bulk delete tersedia saat ini. |
| Penyelesaian | Model dan halaman edit mewajibkan hasil teks atau dokumen hasil saat status selesai. Model mengisi `selesai_at`. |
| Bukti laporan | Route bukti memakai middleware `auth`, tetapi controller belum memeriksa izin melihat pengaduan. |
| Hasil publik | Route unduhan hasil berdasarkan nomor pengaduan saat ini tidak memakai autentikasi; digunakan juga pada pelacakan publik. |
| Panel | Dashboard bawaan masih terdaftar. Terdapat 67 resource; sebagian belum memiliki policy. |

## 4. Matriks akses tahap pertama

Satu akun memiliki satu role. Nilai role: `admin`, `humas`, `fap`, dan `kepala_balai`.

| Kemampuan | Admin | Humas | FAP | Kepala Balai |
| --- | --- | --- | --- | --- |
| Masuk panel jika akun aktif | Ya | Ya | Ya | Ya |
| Mengganti password sendiri dengan password saat ini (spec 002) | Ya | Ya | Ya | Ya |
| Mengelola akun dan menetapkan role | Ya | Tidak | Tidak | Tidak |
| Menghapus akun lain dengan konfirmasi dan proteksi admin | Ya | Tidak | Tidak | Tidak |
| Akses berita dan komentar | Perilaku admin yang ada | Perilaku Humas yang ada | Tidak | Tidak |
| Akses resource admin lainnya | Perilaku admin yang ada | Tidak | Tidak | Tidak |
| Melihat daftar/detail pengaduan | Ya | Tidak | Ya | Ya |
| Mencari, memfilter, dan membaca status pengaduan | Ya | Tidak | Ya | Ya |
| Mengunduh bukti melalui endpoint internal | Ya | Tidak | Ya | Ya |
| Mengubah status, hasil teks, dan dokumen hasil | Ya | Tidak | Ya | Tidak |
| Mengubah laporan asli | Tidak melalui form yang ada | Tidak | Tidak | Tidak |
| Membuat pengaduan dari panel | Tidak ditambahkan | Tidak | Tidak | Tidak |
| Menghapus pengaduan Ditolak dengan alasan manual (spec 003) | Ya, satu per satu | Tidak | Tidak | Tidak |
| Membaca riwayat penghapusan dan lampirannya (spec 003) | Ya | Tidak | Tidak | Ya |
| Dashboard umum | Perilaku admin yang ada | Perilaku Humas yang ada | Dialihkan ke Pengaduan | Dialihkan ke Pengaduan |

Unduhan hasil melalui pelacakan publik merupakan pengecualian dari matriks akses panel: endpoint publik yang sudah ada tetap tersedia dalam tahap ini. Matriks ini tidak menjanjikan bahwa hasil publik hanya dapat diakses oleh tiga role pengaduan.

## 5. Persyaratan fungsional

### FR-01 — Manajemen akun oleh admin

Menu **Manajemen Akun** hanya tersedia untuk admin aktif. Admin dapat melihat daftar akun, menambah akun, mengubah nama/email/role, mereset password akun lain, mengaktifkan atau menonaktifkan akun, serta menghapus akun lain sesuai FR-11. Form menunjukkan ringkasan izin role yang dipilih agar admin memahami menu yang akan tersedia.

Field akun: nama, email unik, role wajib, status aktif, serta password dan konfirmasi password saat membuat akun. Pada edit, password kosong mempertahankan password lama. Password baru minimal 12 karakter, dibatasi menurut hasher (bcrypt 72 byte), disimpan sebagai hash, dan tidak ditampilkan kembali. Reset akun lain mencabut sesi/remember/reset token target. Password admin sendiri diganti melalui Ubah Password dengan verifikasi password saat ini; payload self-reset di Manajemen Akun ditolak. Rincian mengikuti [spec 002](../002-pergantian-password-mandiri/spec.md).

Akun FAP/Kepala Balai dibuat per orang melalui menu ini. Tidak ada akun bersama, kredensial bawaan, ataupun akun sungguhan yang otomatis dibuat oleh migration/seeder.

### FR-02 — Role harus dipilih secara eksplisit

Pembuatan akun melalui panel mewajibkan satu role valid. Akun yang dibuat melalui jalur lain tanpa role valid tidak otomatis menjadi admin dan tidak dapat masuk panel. Perubahan default model/database tidak mengubah role akun existing. Factory pengujian dapat menetapkan role admin secara eksplisit.

### FR-03 — Penonaktifan akun

Semua akun existing tetap aktif setelah migration. Akun nonaktif tidak dapat memakai panel maupun mengunduh bukti internal, termasuk setelah sebelumnya login. Penolakan berlaku pada permintaan berikutnya, termasuk interaksi Livewire. Penonaktifan mencabut akses tanpa menghapus data akun, dan akun dapat diaktifkan kembali. Penghapusan permanen tersedia secara terpisah sesuai FR-11.

### FR-04 — Melindungi akses administrator

Admin tidak dapat menonaktifkan, menurunkan role, atau menghapus akunnya sendiri melalui Manajemen Akun. Aplikasi tidak boleh kehilangan seluruh admin aktif akibat perubahan atau penghapusan akun, termasuk operasi bersamaan. Larangan harus diperiksa saat penyimpanan/penghapusan, bukan hanya dengan menyembunyikan kontrol form.

### FR-05 — Navigasi FAP dan Kepala Balai

Setelah login, FAP/Kepala Balai diarahkan ke daftar Pengaduan. Membuka `/admin` juga mengarah ke daftar tersebut. FAP hanya mendapat Zona Integritas > Pengaduan; Kepala Balai juga mendapat Riwayat Penghapusan baca saja sesuai spec 003. Fitur Zona Integritas lainnya, cluster lain, Manajemen Akun, dan dashboard umum tidak tersedia bagi kedua role.

URL fitur yang dilarang mengembalikan 403 untuk pengguna terautentikasi. Endpoint awal `/admin` adalah pengecualian yang mengalihkan ke daftar Pengaduan. Menu akun dan logout tetap tersedia. Menu Ubah Password pada `/admin/ubah-password` adalah pengecualian keamanan akun sendiri sesuai spec 002; tidak memberi akses resource akun lain.

### FR-06 — Daftar dan detail baca saja

Tambahkan halaman **Lihat Pengaduan** yang dapat dibuka oleh admin, FAP, dan Kepala Balai. Halaman menampilkan nomor, jenis laporan, identitas/kontak pelapor yang tersimpan, pihak yang dilaporkan jika relevan, judul, uraian, status, bukti, hasil teks, dokumen hasil, dan waktu yang tersedia. Kondisi tampil field mengikuti jenis laporan.

Pada resource Pengaduan, Kepala Balai tidak mendapatkan form edit, unggah, tombol simpan, delete, bulk delete, maupun aksi perubahan data. Penggantian password akun sendiri tersedia sesuai spec 002. Membuka URL edit secara langsung atau mencoba aksi penyimpanan ditolak tanpa perubahan database/file. FAP dan admin dapat membuka detail serta halaman edit sesuai izin.

### FR-07 — Tindak lanjut oleh FAP

FAP dapat mengubah hanya `status`, `hasil_teks`, dan dokumen hasil terkait. Metadata dokumen diisi oleh server. Server memakai daftar field yang diizinkan; manipulasi payload tidak dapat mengubah identitas pelapor, laporan asli, nomor laporan, bukti asli, ataupun field lain di luar tindak lanjut.

Pilihan status mengikuti empat status aplikasi saat ini. Status yang tidak dikenal ditolak. Dokumen hasil tetap PDF/JPEG/PNG, maksimal 5 MB, disimpan pada disk privat `local`. File/path dari pengaduan lain tidak boleh dipakai melalui manipulasi input.

### FR-08 — Syarat penyelesaian

Status selesai hanya dapat disimpan jika hasil teks tidak kosong setelah normalisasi spasi atau ada dokumen hasil yang valid. Dokumen yang sudah tersimpan dapat memenuhi syarat. Menghapus satu-satunya hasil lalu menyimpan status selesai harus ditolak.

Perilaku `selesai_at` mengikuti model saat ini. Tahap ini tidak menambahkan persetujuan Kepala Balai, penugasan per anggota, aturan urutan status baru, atau penguncian otomatis laporan selesai.

### FR-09 — Otorisasi seluruh jalur akses

Aturan yang sama berlaku pada menu, halaman, URL langsung, query/global search bila aktif, aksi baris/header, bulk action, dan permintaan Livewire, termasuk endpoint upload sementara. Resource tanpa policy tidak boleh terbuka bagi FAP/Kepala Balai. Custom action dan controller unduhan harus memeriksa izin secara eksplisit.

Humas tetap terbatas pada resource bisnis berita/komentar sesuai perilaku yang ada, ditambah Ubah Password akun sendiri. Pemeriksaan fingerprint sesi berlaku persistent pada panel/Livewire, upload sementara, dan bukti internal sesuai spec 002. Akun nonaktif, role tidak valid, serta akun tanpa role valid tidak mendapat akses internal.

### FR-10 — Unduhan dan jalur publik

Unduhan bukti memerlukan akun aktif dengan izin melihat pengaduan: admin, FAP, atau Kepala Balai. Humas/role lain/nonaktif mendapat 403 meskipun mengetahui URL. Pengunjung yang belum login diarahkan ke login panel. File yang tidak ada mengembalikan 404 untuk pengguna yang berizin.

Pengiriman laporan, penomoran, notifikasi laporan baru, pelacakan publik, dan unduhan hasil publik tetap mengikuti perilaku saat ini untuk pengaduan aktif. Spec 003 mengecualikan pengaduan terhapus dari pelacakan dan unduhan existing; lampiran riwayat hanya dapat diunduh admin/Kepala Balai melalui endpoint internal terpisah. Pembatasan publik dengan token/verifikasi identitas merupakan perubahan terpisah yang perlu spesifikasi sendiri.

### FR-11 — Penghapusan akun oleh admin

Admin aktif dapat menghapus akun lain melalui aksi **Hapus** pada baris daftar dan header halaman Ubah Akun. Dialog konfirmasi menyebutkan nama/email target dan menjelaskan bahwa penghapusan permanen tidak dapat dibatalkan. Membuka dialog atau membatalkan konfirmasi tidak menghapus akun. Penghapusan massal tidak disediakan.

Akun sendiri dan admin aktif terakhir tidak dapat dihapus. Server memeriksa actor dan target terbaru, izin delete, serta keberadaan admin aktif lain dalam transaksi dengan urutan penguncian yang sama seperti perubahan akun. Actor yang sudah dihapus, dinonaktifkan, atau kehilangan role admin tidak boleh memakai form/dialog yang masih terbuka untuk menghapus akun.

Setelah berhasil, akun tidak lagi tercantum pada daftar dan tidak dapat login atau memakai sesi/permintaan Livewire/upload/unduhan internal sebelumnya. Sesi database milik target dibersihkan bila driver sesi memakai database, dan token reset password target dihapus melalui broker aplikasi. Konten berita, pengaduan, dan dokumennya tetap tersimpan; schema saat ini tidak menghubungkan konten tersebut sebagai milik akun panel. Fitur ini tidak menambah soft delete atau pemulihan akun.

## 6. Asumsi tahap pertama

- FAP dan Kepala Balai mengakses seluruh record aktif pada resource Pengaduan, termasuk Pengaduan Pelanggaran, Komplain Layanan, dan WBS. Tidak ada pembagian berdasarkan petugas atau jenis laporan. Riwayat penghapusan mengikuti izin khusus spec 003.
- Kepala Balai dapat membaca identitas pelapor dan dokumen yang sama dengan FAP. Penyembunyian identitas belum diminta.
- Admin menetapkan password awal dan mereset akun lain melalui panel. Semua role aktif dapat mengganti password sendiri secara opsional melalui menu akun sesuai spec 002. Undangan email, lupa password lewat email, dan kewajiban ganti password saat login pertama belum termasuk.
- Status aktif dan proteksi admin berlaku untuk perubahan maupun penghapusan akun. Penonaktifan tetap tersedia bila akses perlu dicabut dengan kemungkinan aktivasi kembali; penghapusan permanen disetujui melalui D-03.

## 7. Skenario penerimaan

| ID | Skenario | Hasil yang harus dibuktikan | Persyaratan |
| --- | --- | --- | --- |
| AC-01 | Admin membuat akun FAP/Kepala Balai | Akun tersimpan dengan role yang dipilih, password hash, dan dapat login. | FR-01, FR-02 |
| AC-02 | Email duplikat, role kosong/tidak valid, atau password tidak memenuhi aturan | Validasi gagal; akun tidak dibuat. | FR-01, FR-02 |
| AC-03 | Admin mengedit akun tanpa mengisi password | Nama/email/role dapat berubah; hash password lama tetap. | FR-01 |
| AC-04 | FAP/Kepala Balai login atau membuka `/admin` | Diarahkan ke Pengaduan; menu lain tidak terlihat. | FR-05 |
| AC-05 | FAP/Kepala Balai membuka resource lain dengan URL langsung | Ditolak 403, termasuk resource tanpa policy dan resource dalam cluster Zona Integritas yang sama. | FR-05, FR-09 |
| AC-06 | Kepala Balai membuka daftar, filter, dan detail | Berhasil; laporan lengkap terbaca; aksi perubahan data tidak tersedia. | FR-06 |
| AC-07 | Kepala Balai membuka URL edit / mencoba save, upload, delete, atau bulk delete | Ditolak; database dan file tidak berubah. | FR-06, FR-09 |
| AC-08 | FAP menyimpan status investigasi dan hasil tindak lanjut | Perubahan tersimpan; laporan asli tetap sama. | FR-07 |
| AC-09 | FAP memanipulasi field laporan asli, mencoba delete/bulk delete, atau mereferensikan file lain | Perubahan terlarang tidak terjadi. | FR-07, FR-09 |
| AC-10 | FAP menandai selesai tanpa teks/dokumen valid | Ditolak; status belum menjadi selesai. | FR-08 |
| AC-11 | FAP menandai selesai dengan hasil valid | Status tersimpan dan waktu selesai mengikuti perilaku model. | FR-08 |
| AC-12 | Admin menonaktifkan akun yang sedang login atau mengganti FAP menjadi Kepala Balai saat form edit terbuka | Permintaan berikutnya memakai izin terbaru; save yang kini dilarang tidak terjadi. | FR-03, FR-09 |
| AC-13 | Admin menonaktifkan/menurunkan role dirinya atau perubahan akan menghilangkan admin aktif terakhir | Ditolak saat penyimpanan. | FR-04 |
| AC-14 | Nonadmin membuka Manajemen Akun atau memanggil aksi tambah/edit/ubah role | Ditolak; tidak terjadi peningkatan akses. | FR-01, FR-09 |
| AC-15 | Bukti diunduh oleh admin/FAP/Kepala Balai versus Humas/nonaktif/tamu | Hanya akun aktif berizin berhasil; lainnya ditolak atau diarahkan ke login sesuai FR-10. | FR-03, FR-10 |
| AC-16 | Regression Admin/Humas dan alur pengaduan publik dijalankan | Pembatasan Humas, batas resource existing, nomor laporan, notifikasi, pelacakan, serta unduhan hasil publik tetap berjalan. | FR-09, FR-10 |
| AC-17 | Admin membuka/membatalkan konfirmasi Hapus, lalu mengonfirmasi penghapusan akun lain dari daftar atau halaman edit | Sebelum konfirmasi akun tetap ada; setelah konfirmasi akun hilang dari database/daftar dan halaman edit kembali ke daftar. | FR-11 |
| AC-18 | Admin mencoba menghapus diri sendiri/admin terakhir; nonadmin, nonaktif, atau actor yang aksesnya dicabut mencoba delete | Ditolak tanpa penghapusan; minimal satu admin aktif tetap tersedia, termasuk dengan actor/target stale. | FR-04, FR-09, FR-11 |
| AC-19 | Akun terhapus memakai login/sesi/form/upload lama | Akses ditolak atau diarahkan ke login; sesi database/reset token target dibersihkan; akun lain dan konten tetap tersedia. | FR-11 |

## 8. Di luar tahap pertama

Editor role/permission dinamis, multi-role per akun, izin khusus per pengguna, approval Kepala Balai, pembagian kasus per petugas, export baru, audit trail lengkap, registrasi publik, dan perubahan keamanan pelacakan publik.

## 9. Metode spec driven development

Spesifikasi ini menjadi acuan perilaku. `plan.md` menerjemahkannya menjadi desain teknis, dan `tasks.md` mengurutkan pekerjaan dengan referensi FR/AC. Test penerimaan ditulis berdasarkan skenario di atas sebelum implementasi terkait. Bila kebutuhan berubah, perbarui spec dan skenario terlebih dahulu, lalu rencana, task, kode, dan hasil verifikasinya.

Setiap perubahan fitur disertai pembaruan dokumen terkait dalam pekerjaan yang sama. Status implementasi, checklist, instruksi penggunaan/migration, dan hasil test harus mengikuti keadaan terbaru yang sudah diperiksa. Baseline dan hasil historis tetap boleh dicatat dengan label yang jelas; jangan menampilkan kondisi lama sebagai status terkini.

Tahap dianggap selesai setelah seluruh persyaratan dalam cakupan terbukti oleh test dan pemeriksaan UI; selesainya dokumen ini belum berarti fitur aplikasi sudah tersedia.

Hasil implementasi dan batas verifikasi tercatat pada [verification.md](verification.md). Langkah aktivasi database dan pembuatan akun operasional tersedia pada [deployment.md](deployment.md).

Pergantian password mandiri pada [spec 002](../002-pergantian-password-mandiri/spec.md) disetujui pada 3 Oktober 2026 dan sudah diimplementasikan. Aturan reset admin serta pengecualian akses akun sendiri di atas mengikuti perubahan tersebut; bukti dan batas regresi terbaru tersedia pada [verifikasi spec 002](../002-pergantian-password-mandiri/verification.md).
