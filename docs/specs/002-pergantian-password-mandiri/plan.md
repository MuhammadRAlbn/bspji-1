# Implementasi Teknis: Pergantian Password Mandiri

Acuan: [spec.md](spec.md), disetujui pengguna pada 3 Oktober 2026. Implementasi selesai; suite proyek lulus 261 test (1.997 assertion). Bukti dan batas verifikasi: [verification.md](verification.md).

## 1. Halaman akun sendiri

`App\Filament\Pages\ChangePassword` memperluas `Filament\Auth\Pages\EditProfile` dengan tiga input password saja. Panel mendaftarkannya melalui `profile(..., isSimple: false)` sehingga menu akun menampilkan Ubah Password pada `/admin/ubah-password` (`filament.admin.auth.profile`). Halaman tidak masuk daftar navigasi resource dan tidak menerima ID target.

`mount`, `hydrate`, dan `save` memeriksa akun/sesi terbaru. Otorisasi halaman tidak memakai `UserPolicy::update`, yang tetap khusus Manajemen Akun oleh admin. Kembali menuju Pengaduan untuk staf dan dashboard untuk Admin/Humas. Setelah sukses, ketiga input dan error dikosongkan; pengguna tetap pada halaman tersebut.

Metode `save` bawaan diganti seluruhnya: form profil bawaan mengubah nama/email, memakai limiter berbeda, dan memperbarui marker sesi sendiri. Halaman ini meneruskan data ke service sebelum validasi form agar semua percobaan server, termasuk input kosong, dihitung. Service menjadi batas validasi/penyimpanan dan hanya memakai field password tervalidasi.

## 2. Penyimpanan dan aturan password

`UserPasswordService::change` mengunci satu baris actor dalam transaksi, memeriksa status/role dan fingerprint sesi terhadap hash terbaru, lalu memvalidasi current password, password baru, serta konfirmasi. Tidak ada query lock akun lain setelah lock tersebut. Jalur admin tetap memakai query lock bersama yang diurutkan menurut ID; pergantian mandiri tidak menambah urutan lock yang berlawanan.

Password baru minimum 12 karakter, dikonfirmasi persis, dan harus berbeda berdasarkan pemeriksaan hash. `PasswordWithinHashLimit` menolak lebih dari 72 byte atau karakter null ketika hasher bcrypt. Rule tersebut juga dipakai pada form/service pembuatan dan reset admin. Password saat ini yang pendek atau lebih panjang dari batas baru tetap dapat diverifikasi. Tidak ada pemotongan input atau backfill password existing. Livewire 4 melewati middleware normalisasi payload, sehingga spasi password dipertahankan.

Semua plaintext baru di-hash secara eksplisit dengan `Hash::make`, termasuk input yang bentuknya menyerupai hash bcrypt. Penyimpanan mengubah password dan remember token; field identitas/role/status pada payload mandiri tidak dipakai. Kegagalan validasi tidak mencabut sesi/token. Test kegagalan cleanup membuktikan rollback password, remember token, dan reset token dalam koneksi database yang sama.

## 3. Jalur admin

Form Manajemen Akun menyembunyikan kedua field reset pada record admin sendiri dan menyediakan tautan Ubah Password. Hook sebelum validasi dan `UserManagementService::update` menolak payload self-reset. Edit nama/email sendiri tetap tersedia sesuai spec 001.

Reset akun lain memakai service, merotasi remember token, mencabut sesi dan reset token target, tanpa mengeluarkan admin. Bila email ikut berubah, token pada email lama dibersihkan sebelum record diperbarui, lalu token email baru dibersihkan melalui revokasi. Edit tanpa password tidak melakukan revokasi. Pembuatan akun tetap hanya oleh admin aktif.

## 4. Sesi dan endpoint

`AccountSessionService` memakai HMAC hash password dari guard sebagai fingerprint pada `password_hash_web`; tidak ada kolom/migration baru. Listener `Login` menstempel snapshot hash dari autentikasi terpercaya. Autentikasi cookie remember memerlukan token yang sah dari guard dan fingerprint cookie yang cocok. Login baru dengan kredensial sah dapat mengganti marker meskipun masih membawa cookie lama. Event `Authenticated` pada request biasa tidak menstempel marker.

`EnsureCurrentAccountSession` membaca akun terbaru dan menolak marker hilang/tidak cocok. Middleware ini persistent pada panel/Livewire, serta dipasang pada upload sementara dan unduhan bukti internal. Trait hydrate resource terkait juga memeriksa sesi. Middleware Filament AuthenticateSession bawaan dilepas agar marker lama tidak otomatis mengadopsi hash terbaru sebelum/sesudah request. Whitelist staf menambahkan hanya route profil sendiri; larangan edit Kepala Balai tetap khusus Pengaduan.

Pada pergantian mandiri, baris sesi database lain dihapus, reset token dihapus lewat broker, dan remember token dirotasi dalam transaksi. Setelah commit, guard dan marker diperbarui dari model/hash hasil penyimpanan, bukan pembacaan terbaru yang mungkin sudah direset lagi. ID sesi saat ini diregenerasi dengan penghapusan ID lama; cookie remember saat ini dibersihkan. Saat menolak sesi stale, `logoutCurrentDevice` tidak merotasi remember token baru milik sesi sah.

Driver database memakai connection/table sesi yang dikonfigurasi. Request lama yang menulis kembali baris sesi setelah reset tetap membawa marker lama dan ditolak pada permintaan berikutnya. Driver non-database mengandalkan fingerprint karena tidak dibersihkan dengan query tabel. Test memakai sesi array/database dan preview memakai file; Redis serta konkurensi transaksi MySQL paralel belum diuji.

Sesi sebelum deployment yang belum memakai fingerprint HMAC perlu login ulang; password dan kewajiban mengganti password tidak berubah. Jalur publik Pengaduan tidak memakai middleware sesi internal ini.

## 5. Pembatasan percobaan

Limiter aplikasi menghitung 5 percobaan/menit per akun dan 20/menit per IP. Precheck diikuti increment cache atomik dan pemeriksaan hasil increment, sehingga request yang melewati batas saat admission tidak meneruskan verifikasi password. Pesan memberi waktu tunggu; pembatasan tidak menonaktifkan akun atau logout. Produksi perlu cache limiter bersama antarworker/instance. Tidak ada limiter tambahan dari save profil bawaan.

## 6. Verifikasi dan dokumen

`PasswordManagementTest` memuat skenario FR/AC, request HTTP/Livewire, dua sesi database, cookie remember, payload, transaksi gagal, dan batas percobaan. `Tests\TestCase::actingAs` menyiapkan fingerprint sebagai fixture autentikasi terpercaya; test login kredensial HTTP terpisah membuktikan listener tanpa helper tersebut. Test endpoint Livewire aktual memakai snapshot halaman dan middleware request normal.

Suite spec 001 dan seluruh suite proyek memeriksa regresi izin akun/Pengaduan/Humas dan fitur publik. UI diperiksa dengan fixtures dan database preview terpisah. Penggantian password melalui browser tidak dilakukan; keberhasilan simpan, pencabutan sesi, dan input kosong diuji otomatis. [deployment.md](deployment.md) memuat penggunaan, konfigurasi, dan dampak sesi saat aktivasi. Spec 001, checklist, dan hasil test diperbarui pada pekerjaan ini.
