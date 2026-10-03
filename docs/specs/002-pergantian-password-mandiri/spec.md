# Spesifikasi: Pergantian Password Mandiri

Tanggal: 3 Oktober 2026 (Asia/Jakarta).

Status: **Disetujui pengguna pada 3 Oktober 2026; implementasi selesai dan suite proyek lulus 261 test (1.997 assertion).** Seluruh cakupan D-01–D-05 dan FR-01–FR-07 telah disepakati.

Acuan fitur yang sudah tersedia: [001 — Manajemen Akun dan Akses Pengaduan](../001-manajemen-akun-pengaduan/spec.md).

## 1. Tujuan

Setiap pengguna dapat mengganti password akunnya sendiri setelah menerima akun dari admin, tanpa memberikan password pilihannya kepada admin. Fitur tersedia melalui menu akun di pojok kanan atas panel. Hak akses bisnis tiap role tetap mengikuti spec 001.

## 2. Keputusan yang disepakati

| ID | Keputusan/usulan | Status |
| --- | --- | --- |
| D-01 | Pergantian password opsional; tidak ada kewajiban mengganti pada login pertama atau setelah reset admin. | Dikonfirmasi pengguna. |
| D-02 | Password baru tetap minimal 12 karakter, termasuk pembuatan/reset oleh admin. Password existing tidak dipaksa berubah. | Dikonfirmasi pengguna. |
| D-03 | Semua role aktif dapat memakai menu Ubah Password untuk akunnya sendiri; form hanya berisi password saat ini, baru, dan konfirmasi. | Disetujui pengguna. |
| D-04 | Setelah berhasil, sesi saat ini tetap login dengan ID sesi baru; sesi perangkat lain, remember token lama, dan reset token dicabut. | Disetujui pengguna. |
| D-05 | Penggantian password admin sendiri memakai menu Ubah Password. Reset tanpa password saat ini di Manajemen Akun berlaku untuk akun lain. | Disetujui pengguna. |

## 3. Baseline sebelum implementasi

Bagian ini mencatat kondisi sebelum spec 002, bukan perilaku aplikasi terkini. Implementasi tersedia; hasil pengujian dan batasnya dicatat pada [verification.md](verification.md).

- Panel belum mengaktifkan halaman profil/pergantian password mandiri. Admin dapat menetapkan password awal dan mengganti password melalui Manajemen Akun.
- Form Manajemen Akun dan service saat ini memakai minimum 12 karakter dan konfirmasi password; password kosong saat edit mempertahankan hash lama.
- FAP/Kepala Balai dibatasi pada Pengaduan, cluster terkait, dan logout. Menu keamanan akun sendiri perlu menjadi pengecualian eksplisit tanpa membuka resource Manajemen Akun.
- Filament 5.4.2 memiliki halaman EditProfile dengan validasi current password, tetapi form bawaan juga mengubah nama/email. Mengaktifkan seluruh form bawaan tidak sesuai cakupan password saja.
- Panel memakai AuthenticateSession, tetapi belum mendaftarkannya sebagai middleware persistent. Upload sementara dan unduhan bukti internal memerlukan pemeriksaan sesi yang sesuai karena berada pada jalur berbeda.
- Konfigurasi aplikasi saat diperiksa memakai sesi database. Hasher default framework adalah bcrypt; perencanaan harus menghindari pemotongan input panjang saat hashing.

## 4. Matriks akses

| Kemampuan | Admin aktif | Humas aktif | FAP aktif | Kepala Balai aktif | Tamu/nonaktif/role tidak valid |
| --- | --- | --- | --- | --- | --- |
| Membuka Ubah Password milik sendiri | Ya | Ya | Ya | Ya | Tidak |
| Mengganti password sendiri dengan verifikasi password saat ini | Ya | Ya | Ya | Ya | Tidak |
| Mereset password akun lain dari Manajemen Akun | Ya | Tidak | Tidak | Tidak | Tidak |
| Mengubah role/status/nama/email melalui Ubah Password | Tidak | Tidak | Tidak | Tidak | Tidak |

## 5. Persyaratan fungsional

### FR-01 — Akses akun sendiri

Menu **Ubah Password** tersedia pada menu akun untuk semua role aktif yang sah. Halaman tidak menerima ID akun target dari URL/payload; identitas target selalu pengguna yang terautentikasi. Halaman ini tidak membuka daftar akun atau izin mengedit akun lain.

Pengguna nonaktif, terhapus, tamu, atau role tidak valid tidak dapat menyimpan perubahan. Pemeriksaan berlaku pada URL langsung dan permintaan Livewire, dengan data akun terbaru saat penyimpanan.

### FR-02 — Form dan validasi

Form memuat **Password Saat Ini**, **Password Baru**, **Konfirmasi Password Baru**, dan tombol **Simpan Password**. Ketiga input wajib; password baru minimal 12 karakter, konfirmasi cocok, dan berbeda dari password yang saat ini berlaku.

Spasi dan karakter khusus boleh digunakan; tidak ditambahkan kewajiban kombinasi huruf besar/kecil/angka/simbol atau pergantian berkala. Input tidak dipotong atau dinormalisasi sehingga mengubah password yang dimaksud pengguna. Password baru yang melebihi batas hasher aktif ditolak dengan pesan validasi; dengan bcrypt, batas teknisnya 72 byte. Batas server juga berlaku pada pembuatan/reset password baru oleh admin agar aturan konsisten.

Password tidak diisi kembali dari database. Verifikasi current password memakai hash terbaru, bukan salinan akun ketika form dibuka. Input salah atau tidak cocok tidak mengubah hash, sesi, token, maupun field akun lain.

### FR-03 — Pergantian opsional

Pengguna dapat tetap mengakses fitur yang diizinkan tanpa mengganti password awal. Tidak ada redirect paksa, status wajib ganti password, expiry periodik, atau flag login pertama. Akun yang telah dibuat tetap memakai password yang berlaku sampai diganti pengguna atau direset admin.

### FR-04 — Izin role dan alur navigasi

FAP/Kepala Balai tetap hanya mendapat akses bisnis Pengaduan, ditambah halaman Ubah Password milik sendiri. Mereka tidak mendapat akses Manajemen Akun, dashboard umum, atau resource lainnya. Halaman Ubah Password milik sendiri boleh dibuka oleh Kepala Balai meskipun edit Pengaduan tetap dilarang.

Setelah pergantian berhasil, tampilkan notifikasi keberhasilan, kosongkan input password, dan pertahankan pengguna pada halaman tersebut. Tautan **Kembali** menuju Pengaduan untuk FAP/Kepala Balai, dan dashboard sesuai izin existing untuk Admin/Humas. Tujuan login normal mengikuti spec 001.

### FR-05 — Penyimpanan dan pencabutan sesi

Penyimpanan hanya mengubah hash password dan token keamanan yang terkait. Actor dibaca ulang dan dikunci selama verifikasi/penyimpanan, termasuk ketika admin telah melakukan reset atau penonaktifan sementara form terbuka. Form lama tidak boleh menimpa reset dengan password saat ini yang sudah tidak berlaku.

Setelah penyimpanan berhasil, sesi perangkat saat ini dipertahankan dengan ID baru dan data autentikasi terbaru. Sesi perangkat lain dan cookie Ingat Saya yang lama tidak dapat dipakai lagi. Token reset password lama dibersihkan. Percobaan gagal tidak mencabut sesi.

Penolakan sesi lama berlaku pada halaman panel, permintaan Livewire, upload sementara, serta unduhan bukti internal. Cookie/sesi yang ditolak memerlukan login baru. Reset password akun lain oleh admin juga mencabut seluruh sesi dan token lama target, tanpa mengeluarkan admin yang mereset. Pengiriman/pelacakan pengaduan dan unduhan hasil publik tetap mengikuti pengecualian spec 001.

### FR-06 — Reset admin dan penutupan jalur pintas

Admin tetap boleh membuat akun dan mereset password akun lain tanpa mengetahui password target saat ini. Password kosong pada edit akun tetap tidak mengubah password atau sesi target.

Saat admin mengedit akunnya sendiri di Manajemen Akun, penggantian password diarahkan ke halaman Ubah Password. Field reset password sendiri tidak tersedia pada form itu, dan payload password yang dimanipulasi harus ditolak server. Edit nama/email akun sendiri tetap mengikuti spec 001. Halaman Ubah Password tidak menampilkan kontrol nama/email/role/status.

### FR-07 — Pembatasan percobaan dan kerahasiaan

Permintaan penggantian dibatasi maksimal 5 percobaan per menit per akun dan 20 per menit per IP pada server, termasuk validasi yang gagal. Pembatasan bukan penonaktifan akun permanen dan tidak menghalangi logout. Pesan batas percobaan memberi tahu kapan dapat mencoba lagi.

Password/hash tidak ditampilkan dalam notifikasi atau dicatat dalam log aplikasi. CSRF dan autentikasi panel tetap berlaku. Penggunaan produksi mengikuti transport HTTPS aplikasi.

## 6. Skenario penerimaan

| ID | Skenario | Hasil yang diharapkan | Acuan |
| --- | --- | --- | --- |
| AC-01 | Setiap role aktif membuka menu/URL Ubah Password | Form milik sendiri tersedia; FAP/Kepala tidak memperoleh resource akun lain. | FR-01, FR-04 |
| AC-02 | Password saat ini benar, password baru memenuhi aturan, konfirmasi cocok | Hash berubah; password lama gagal login, yang baru berhasil; input kosong dan notifikasi sukses. | FR-02, FR-05 |
| AC-03 | Password saat ini salah, kurang dari 12 karakter, sama dengan password lama, konfirmasi salah, atau melewati batas hasher | Validasi menolak; akun, hash, sesi, dan token tetap. | FR-02 |
| AC-04 | Pengguna tidak pernah mengganti password awal | Login dan fitur role tetap dapat dipakai tanpa redirect wajib ganti. | FR-03 |
| AC-05 | Payload mengganti ID akun, role, aktif, nama, atau email | Tidak mengubah target/field terlarang; hanya akun yang login dapat mengganti passwordnya. | FR-01, FR-05 |
| AC-06 | Admin mereset password/nonaktifkan/hapus akun ketika form pengguna masih terbuka | Form lama ditolak berdasarkan akun/hash terbaru tanpa menimpa reset. | FR-01, FR-05 |
| AC-07 | Pengguna memiliki dua sesi dan Ingat Saya sebelum mengganti password | Sesi saat ini memakai ID baru dan tetap login; sesi lain/cookie lama ditolak, termasuk Livewire/upload/bukti. | FR-05 |
| AC-08 | Admin mereset password akun lain atau menyimpan edit tanpa password | Reset mencabut sesi/token target; edit tanpa password tidak mencabutnya. Admin tetap login. | FR-05, FR-06 |
| AC-09 | Admin mencoba reset password sendiri lewat form/payload Manajemen Akun | Diarahkan memakai Ubah Password; payload reset sendiri ditolak. Reset akun lain tetap berhasil. | FR-06 |
| AC-10 | Akun/IP melewati batas percobaan | Dibatasi sesuai interval; tidak menyimpan perubahan dan dapat mencoba lagi setelah batas lewat. | FR-07 |
| AC-11 | Tamu/nonaktif/terhapus/role tidak valid mengakses langsung atau memakai komponen lama | Login diperlukan atau akses ditolak; tidak ada perubahan password. | FR-01 |
| AC-12 | Regresi akun, Humas, Pengaduan, dokumen, dan fitur publik | Seluruh izin/proteksi spec 001 serta alur publik tetap bekerja. | FR-04–FR-06 |

## 7. Di luar cakupan

Lupa password melalui email, undangan aktivasi, wajib ganti pada login pertama, penggantian berkala, MFA, perubahan nama/email mandiri, dan audit trail lengkap. Bila pengguna lupa password saat ini, admin meresetnya melalui Manajemen Akun.

## 8. Metode dan persetujuan

Pengguna menyetujui seluruh spesifikasi pada 3 Oktober 2026 setelah mengonfirmasi pergantian opsional dan minimum 12 karakter. Test penerimaan ditulis lebih dahulu, kemudian halaman, service, dan penjagaan sesi diimplementasikan. Percobaan menjalankan test awal sebelum implementasi terhalang pemeriksaan ACL sandbox Windows pada bootstrap PHPUnit; tidak dicatat sebagai hasil test merah yang terverifikasi. Test berjalan setelah sandbox disesuaikan untuk proses PHP.

Rincian implementasi tersedia pada [plan.md](plan.md), checklist pada [tasks.md](tasks.md), hasil pada [verification.md](verification.md), dan panduan penggunaan pada [deployment.md](deployment.md). Dokumen spec 001 ikut diperbarui untuk aturan password admin dan pengecualian akses akun sendiri. Tidak ada migration atau perubahan akun operasional untuk spec 002.

## 9. Dasar rekomendasi

[OWASP Authentication Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html#change-password-feature) menyarankan sesi aktif dan verifikasi password saat ini untuk pergantian password. [NIST SP 800-63B-4](https://pages.nist.gov/800-63-4/sp800-63b.html) menetapkan minimum 15 karakter untuk autentikasi password sebagai faktor tunggal dalam pedomannya; pengguna memilih tetap 12 pada tahap ini. Spesifikasi ini tidak menyatakan aplikasi memenuhi seluruh standar NIST.
