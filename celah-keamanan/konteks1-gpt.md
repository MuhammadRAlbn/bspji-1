# Analisis Keamanan Access Log Website Laravel

## Kesimpulan Utama

**Server sedang dipindai secara aktif oleh banyak bot otomatis.**

Pola trafik yang ditemukan mencakup:

* Pencarian panel administrator.
* Pencarian phpMyAdmin dan Adminer.
* Pencarian file webshell.
* Percobaan path traversal.
* Percobaan Local File Inclusion atau LFI.
* Percobaan Cross-Site Scripting atau XSS.
* Percobaan Remote Code Execution atau RCE.
* Percobaan eksploitasi terhadap berbagai aplikasi, framework, dan layanan yang umum digunakan di internet.

Namun, berdasarkan **access log ini saja, belum ditemukan bukti kuat bahwa server berhasil ditembus**.

Sebagian besar payload berbahaya menghasilkan respons:

* `404 Not Found`
* `403 Forbidden`

Beberapa request menghasilkan status `200 OK`, tetapi status tersebut belum tentu menandakan eksploitasi berhasil. Dalam beberapa kasus, server kemungkinan hanya mengembalikan halaman utama atau fallback Laravel.

## Penilaian Kondisi Keamanan

| Aspek                            | Penilaian                     |
| -------------------------------- | ----------------------------- |
| Percobaan serangan               | **Terkonfirmasi**             |
| Eksploitasi berhasil             | **Belum terkonfirmasi**       |
| Indikasi webshell aktif          | **Tidak ditemukan dalam log** |
| WAF atau ModSecurity             | **Kemungkinan sudah aktif**   |
| Paparan halaman administrator    | **Terkonfirmasi**             |
| Paparan cPanel, WHM, dan Webmail | **Terkonfirmasi**             |
| Prioritas penanganan             | **Tinggi**                    |

---

# Ringkasan Hasil Parsing Log

File log terdiri dari **343 request** yang berasal dari **56 alamat IP**.

Rentang waktu log adalah sekitar:

* **14 Juli 2026 pukul 19.40 WIB**

* Hingga **15 Juli 2026 pukul 09.17 WIB**

## Distribusi Status Respons

| Status | Jumlah | Persentase | Arti                                                            |
| -----: | -----: | ---------: | --------------------------------------------------------------- |
|  `404` |    240 |      70,0% | Endpoint atau file tidak ditemukan                              |
|  `200` |     54 |      15,7% | Respons berhasil, tetapi tidak selalu berarti eksploit berhasil |
|  `403` |     28 |       8,2% | Request kemungkinan diblokir WAF atau server                    |
|  `301` |     17 |       5,0% | Redirect permanen                                               |
|  `302` |      3 |       0,9% | Redirect sementara, terutama pada `/admin`                      |
|  `500` |      1 |       0,3% | Error internal yang harus diperiksa                             |

Setidaknya **301 dari 343 request**, atau sekitar **87,8%**, dapat dikategorikan secara jelas sebagai aktivitas scanning atau probing otomatis.

---

# IP yang Paling Agresif

| IP                | Jumlah Request | Aktivitas Utama                                                          | Tingkat Perhatian |
| ----------------- | -------------: | ------------------------------------------------------------------------ | ----------------- |
| `103.59.45.205`   |             82 | Enumerasi login, administrator, cPanel, API, dan Tomcat                  | Tinggi            |
| `103.187.227.62`  |             50 | Mencari phpMyAdmin dan Adminer                                           | Tinggi            |
| `125.166.126.89`  |             40 | Pola enumerasi panel yang sama                                           | Tinggi            |
| `36.78.105.198`   |             32 | Multi-CVE, LFI, Bitrix, WordPress, dan Java Faces                        | Sangat tinggi     |
| `103.134.221.38`  |             28 | RCE, XSS, upload shell, Solr, dan OFBiz; menghasilkan satu respons `500` | Sangat tinggi     |
| `157.10.90.5`     |             20 | cPanel, Webmail, WHM, dan Adminer                                        | Sangat tinggi     |
| `182.253.151.208` |              9 | Command injection, pembacaan `/etc/passwd`, dan ColdFusion               | Tinggi            |

Terdapat pula aktivitas serangan terdistribusi dari beberapa rentang IP berikut:

```text
45.132.227.*
172.98.32.*
136.144.42.*
```

Rentang IP tersebut mencoba mengakses puluhan nama file yang umum digunakan sebagai webshell, antara lain:

```text
flower.php
chosen.php
zwso.php
txets.php
style.php
ms-themes.php
file.php
bless.php
akcc.php
abcd.php
shelp.php
wp-editor.php
bolt.php
goods.php
```

Seluruh request terhadap file-file tersebut menghasilkan status `404`, sehingga file yang dicari tidak ditemukan pada website.

---

# Temuan Keamanan Penting

## 1. Enumerasi Halaman Administrator Laravel

Scanner menemukan beberapa pola respons berikut:

* `/admin` menghasilkan status `302`.
* `/admin/login` menghasilkan status `200`.
* `/administrator` menghasilkan status `404`.
* `/backend` menghasilkan status `404`.
* `/login.php` menghasilkan status `404`.
* `/dashboard` menghasilkan status `404`.
* `/api/login` menghasilkan status `404`.

Kemungkinan besar endpoint `/admin` mengarahkan pengguna menuju `/admin/login`.

Hal ini bukan kerentanan secara langsung. Namun, scanner telah mengetahui lokasi halaman autentikasi administrator aplikasi.

Pada access log ini belum terlihat request `POST` menuju `/admin/login`.

Artinya, belum terdapat bukti adanya percobaan brute force password terhadap login Laravel pada potongan log tersebut. Aktivitas yang terlihat masih berupa reconnaissance atau pemetaan endpoint menggunakan request `HEAD`.

---

## 2. cPanel, Webmail, dan WHM Dapat Diakses dari Internet

Beberapa endpoint berikut menghasilkan status `200`:

```text
/cpanel
/webmail
/whm
/controlpanel
```

Respons memiliki ukuran sekitar 34 KB, sehingga kemungkinan besar merupakan halaman login cPanel, Webmail, atau WHM yang sebenarnya, bukan halaman fallback Laravel.

Status `200` tidak berarti scanner berhasil melakukan login.

Status tersebut hanya menunjukkan bahwa halaman layanan dapat dibuka dari internet. Namun, karena layanan dapat dikenali dan diakses publik, layanan tersebut berpotensi menjadi sasaran:

* Brute force username dan password.
* Password spraying.
* Credential stuffing.
* Eksploitasi kerentanan panel hosting.
* Pemindaian versi layanan.

Aktifkan dan periksa **cPHulk Brute Force Protection**, karena cPHulk dirancang untuk melindungi layanan berikut:

* cPanel.
* WHM.
* Webmail.
* FTP.
* SSH.
* Layanan autentikasi lain yang terintegrasi dengan cPanel.

Akses cPanel, WHM, dan Webmail juga sebaiknya dibatasi berdasarkan IP melalui **Host Access Control**, apabila layanan hanya digunakan dari jaringan kantor, VPN, atau IP tertentu.

Referensi:

* [cPHulk Brute Force Protection](https://docs.cpanel.net/whm/security-center/cphulk-brute-force-protection/)
* [Tips to Make Your Server More Secure](https://docs.cpanel.net/knowledge-base/security/tips-to-make-your-server-more-secure/)

---

## 3. Percobaan Mengakses phpMyAdmin dan Adminer

Terdapat puluhan akses menuju endpoint berikut:

```text
/phpmyadmin
/phpMyAdmin
/phpmyadmin/
/pma
/adminer
/adminer/
/adminer.php
```

Sebagian besar request menghasilkan:

```text
404 Not Found
```

Sementara endpoint dengan trailing slash seperti `/phpmyadmin/` atau `/adminer/` menghasilkan:

```text
301 Moved Permanently
```

Tidak ditemukan respons `200` untuk phpMyAdmin atau Adminer pada access log ini.

Dengan demikian, belum terlihat adanya instalasi phpMyAdmin atau Adminer yang dapat diakses langsung melalui jalur tersebut.

Meski demikian, tetap perlu diperiksa apakah:

* phpMyAdmin tersedia melalui subdomain lain.
* phpMyAdmin tersedia melalui URL khusus cPanel.
* Adminer tersedia dengan nama file yang berbeda.
* Terdapat file database manager di dalam direktori publik.
* Terdapat salinan lama phpMyAdmin yang belum dihapus.

---

## 4. Percobaan Local File Inclusion dan Path Traversal

Ditemukan beberapa request yang mencoba membaca file sensitif pada server.

Contoh payload:

```text
/index.php?sl=../../../../../../../etc/passwd%00
```

```text
/assets/file:%2f%2f/etc/passwd
```

```text
?lang=../../../../../../../../../../../usr/local/lib/php/pearcmd
```

```text
/WEB-INF/web.xml
```

Tujuan payload tersebut antara lain:

* Membaca file `/etc/passwd`.
* Membaca file konfigurasi aplikasi.
* Membaca konfigurasi Java.
* Mengakses file di luar document root.
* Menyalahgunakan `pearcmd.php`.
* Menguji kemungkinan Local File Inclusion.
* Menguji kemungkinan path traversal.

Salah satu request berikut menghasilkan status `200`:

```text
/index.php?sl=../../../../../../../etc/passwd%00
```

Namun, status `200` tersebut belum berarti isi `/etc/passwd` berhasil dibaca.

Terdapat indikasi bahwa request tersebut hanya menerima halaman utama atau fallback Laravel karena:

* Ukuran respons payload sekitar `28711` byte.
* Ukuran halaman `/` dari scanner yang sama sekitar `28704` hingga `28715` byte.
* Payload `/?echo+...` juga menghasilkan ukuran respons yang hampir identik.

Kesamaan ukuran respons menunjukkan kemungkinan besar server mengembalikan halaman yang sama, bukan isi file `/etc/passwd`.

Meski demikian, access log tidak menyimpan body respons. Oleh karena itu, hasil eksploitasi tidak dapat dipastikan hanya berdasarkan status dan ukuran respons.

Verifikasi tetap diperlukan melalui:

* Log Laravel.
* Log Apache atau Nginx.
* Log ModSecurity.
* Pengujian internal menggunakan request yang aman.
* Pemeriksaan kode controller dan route fallback.

---

## 5. Percobaan Command Injection dan Remote Code Execution

Ditemukan berbagai payload yang mencoba menjalankan perintah pada server.

Jenis payload yang ditemukan meliputi:

* Reverse shell menggunakan `mkfifo`.
* Pemanggilan `/bin/sh`.
* Penggunaan `curl` untuk mengunduh atau menghubungi server eksternal.
* Callback menuju domain OAST atau interact.
* Penyalahgunaan parameter `PDF2SWF_PATH`.
* Percobaan command execution pada FuelCMS.
* Percobaan eksploitasi Oracle Reports.
* Percobaan eksploitasi Bitrix.
* Percobaan Server-Side Request Forgery atau SSRF.
* Percobaan eksploitasi Apache Solr.
* Percobaan eksploitasi ColdFusion.
* Percobaan eksploitasi Java Faces.
* Percobaan eksploitasi Apache OFBiz atau WebTools.
* Percobaan upload webshell.
* Percobaan menemukan file shell yang telah diunggah.

Sebagian request diblokir dengan status:

```text
403 Forbidden
```

Sebagian request menghasilkan:

```text
404 Not Found
```

Sebagian lainnya menghasilkan redirect.

Karena aplikasi yang dianalisis menggunakan Laravel dan bukan:

* WordPress.
* Bitrix.
* Java Faces.
* Apache Solr.
* ColdFusion.
* Oracle Reports.
* FuelCMS.
* Apache OFBiz.

Maka pola ini menunjukkan bahwa penyerang kemungkinan menggunakan **scanner internet generik** yang mencoba banyak CVE sekaligus.

Aktivitas tersebut belum terlihat sebagai serangan yang dirancang secara khusus terhadap source code Laravel website ini.

---

## 6. Satu Respons `500` Harus Diperiksa Segera

Terdapat satu request yang menghasilkan error internal server:

```text
Tanggal  : 15 Juli 2026
Waktu    : 00:41:36 WIB
IP       : 103.134.221.38
Method   : POST
Endpoint : /webtools/control/httpService
Status   : 500
Ukuran   : 800 byte
```

Request tersebut berada di tengah rangkaian payload eksploitasi terhadap Apache OFBiz atau WebTools.

Status `500` belum berarti eksploitasi berhasil.

Beberapa kemungkinan penyebabnya adalah:

1. Request masuk ke Laravel dan menyebabkan exception.
2. Middleware gagal memproses request body tertentu.
3. WAF atau ModSecurity mengalami error saat memproses payload.
4. Web server meneruskan request ke handler yang tidak sesuai.
5. Route fallback tidak menangani request dengan method `POST`.
6. Error terjadi pada reverse proxy.
7. Error berasal dari konfigurasi hosting.
8. Payload menyebabkan error pada proses parsing URI atau body.
9. Terdapat error pada package atau middleware global.

Hal yang paling penting adalah mencari stack trace pada waktu yang sama.

Jalankan perintah berikut dari root aplikasi Laravel:

```bash
grep -Rni "webtools/control/httpService" storage/logs
```

```bash
grep -Rni "103.134.221.38" storage/logs
```

```bash
grep -Rni "2026-07-15 00:41" storage/logs
```

Apabila Laravel menggunakan timezone UTC, cari pula log pada waktu sekitar:

```text
14 Juli 2026 pukul 17.41 UTC
```

Periksa juga:

* Apache error log.
* Nginx error log.
* PHP-FPM log.
* ModSecurity audit log.
* Log reverse proxy.
* Log aplikasi Laravel.
* Log hosting atau cPanel.

---

## 7. WAF atau ModSecurity Kemungkinan Sudah Bekerja

Banyak payload eksploitasi menerima respons:

```text
403 Forbidden
```

Respons `403` tersebut memiliki ukuran yang sama, yaitu sekitar:

```text
1242 byte
```

Pola respons yang seragam menunjukkan kemungkinan adanya halaman blokir dari:

* ModSecurity.
* Web Application Firewall.
* Security plugin hosting.
* Reverse proxy.
* Firewall aplikasi.

Hal ini merupakan indikasi positif karena beberapa payload berbahaya berhasil diblokir, termasuk:

* Oracle Reports.
* Java Faces.
* Apache Solr.
* Reverse shell.
* Beberapa payload WordPress.
* Percobaan pembacaan file konfigurasi.
* Percobaan command injection.

Namun, terdapat pula request yang mengaku sebagai Bingbot dan mendapatkan respons `403`, termasuk ketika mengakses:

* Halaman publik.
* Dokumen publik.
* Sitemap.
* Robots.
* Halaman layanan.
* Endpoint download.

Jangan langsung melakukan allowlist hanya berdasarkan nilai `User-Agent`, karena `User-Agent` dapat dipalsukan dengan mudah.

Apabila ingin mengizinkan crawler tertentu, lakukan validasi menggunakan:

* Reverse DNS.
* Forward-confirmed reverse DNS.
* Daftar IP resmi crawler.
* Log WAF.
* Rule ID ModSecurity yang menyebabkan blokir.

Periksa ModSecurity audit log untuk mengetahui rule yang aktif dan rule yang menghasilkan false positive.

cPanel merekomendasikan penggunaan ModSecurity bersama **OWASP Core Rule Set** untuk membantu melindungi aplikasi web.

Referensi:

* [Tips to Make Your Server More Secure](https://docs.cpanel.net/knowledge-base/security/tips-to-make-your-server-more-secure/)

---

# Apakah Website Sudah Diretas?

## Kesimpulan

**Belum ditemukan bukti kuat dari access log ini bahwa aplikasi berhasil diretas.**

Beberapa indikator yang mendukung kesimpulan tersebut:

* Mayoritas payload menghasilkan `404`.
* Banyak payload berbahaya diblokir dengan `403`.
* Seluruh pencarian nama file webshell menghasilkan `404`.
* Tidak ditemukan akses `200` menuju file `.php` webshell yang dicoba.
* Tidak terlihat adanya upload file yang berhasil.
* Tidak terlihat adanya login administrator yang berhasil.
* Tidak terlihat request `POST` menuju `/admin/login`.
* Tidak terlihat akses langsung menuju `.env`.
* Tidak terlihat akses menuju direktori `.git`.
* Tidak terlihat eksploitasi `vendor/phpunit`.
* Tidak terlihat akses menuju `laravel.log`.
* Respons `200` untuk payload LFI memiliki ukuran hampir sama dengan halaman utama.
* Tidak ditemukan bukti pembacaan `/etc/passwd`.
* Tidak ditemukan bukti command execution yang berhasil.
* Tidak ditemukan bukti callback keluar menuju server penyerang dalam access log.

Namun, access log hanya menunjukkan:

* Alamat IP.
* Waktu request.
* Method.
* URL.
* Status HTTP.
* Ukuran respons.
* Referer.
* User-Agent.

Access log tidak dapat membuktikan:

* Isi body respons.
* Isi body request.
* Perubahan file.
* File yang diunggah.
* File yang dihapus.
* Perintah sistem yang dijalankan.
* Proses mencurigakan yang aktif.
* Koneksi keluar dari server.
* Perubahan database.
* Penambahan akun administrator.
* Pencurian session.
* Pencurian kredensial.
* Eksekusi webshell.
* Perubahan cron job.
* Perubahan konfigurasi server.

Oleh sebab itu, pemeriksaan lanjutan tetap wajib dilakukan.

---

# Tindakan Prioritas

## Prioritas 1 — Verifikasi Kemungkinan Insiden

Lakukan pemeriksaan integritas file dan log server.

### Cari file PHP yang baru dibuat atau baru berubah

```bash
find public storage/app/public \
  -type f \
  \( -iname "*.php" -o -iname "*.phtml" -o -iname "*.phar" \) \
  -mtime -2 -ls
```

Tujuan pemeriksaan ini adalah mencari:

* File PHP baru.
* Webshell.
* Backdoor.
* File upload berbahaya.
* File PHP yang diletakkan di direktori upload.
* File yang dimodifikasi pada waktu serangan.

### Periksa perubahan source code menggunakan Git

```bash
git status --short
```

```bash
git diff --stat
```

```bash
git diff
```

Apabila terdapat perubahan yang tidak dikenal, periksa:

* Waktu perubahan.
* Pemilik file.
* Isi perubahan.
* Apakah perubahan berasal dari proses deployment.
* Apakah file dibuat oleh user web server.

### Cari pola fungsi yang umum digunakan webshell

```bash
grep -RIlE \
'eval\s*\(|base64_decode\s*\(|shell_exec\s*\(|passthru\s*\(|proc_open\s*\(|system\s*\(' \
public storage/app/public
```

Perlu diperhatikan bahwa beberapa fungsi tersebut dapat digunakan secara sah oleh package tertentu. Oleh karena itu, setiap hasil tetap harus dianalisis secara manual.

### Audit dependency Composer

```bash
composer audit
```

Tujuannya adalah menemukan dependency PHP yang memiliki kerentanan keamanan yang telah diketahui.

### Lihat route administrator yang aktif

```bash
php artisan route:list --path=admin
```

Periksa apakah terdapat:

* Route admin yang tidak dikenal.
* Route tanpa middleware autentikasi.
* Route tanpa middleware authorization.
* Route debug.
* Route testing.
* Route upload yang tidak terlindungi.

### Pemeriksaan tambahan

Periksa juga:

* Cron job.
* Laravel scheduler.
* Queue worker.
* Supervisor.
* Akun administrator baru.
* Login cPanel yang tidak dikenal.
* Login SSH yang tidak dikenal.
* Login FTP yang tidak dikenal.
* Perubahan file `.env`.
* Perubahan konfigurasi web server.
* Perubahan permission file.
* Proses sistem yang mencurigakan.
* Koneksi keluar server.
* Database user yang baru dibuat.
* API token yang baru dibuat.

---

## Prioritas 2 — Pastikan Konfigurasi Production Laravel

Pastikan konfigurasi berikut digunakan pada file `.env`:

```env
APP_ENV=production
APP_DEBUG=false
```

`APP_DEBUG` harus selalu bernilai `false` pada server production.

Apabila `APP_DEBUG=true`, halaman error Laravel dapat menampilkan informasi sensitif seperti:

* Path direktori server.
* Nama class.
* Stack trace.
* Query database.
* Variabel lingkungan.
* Nama database.
* Informasi konfigurasi.
* Potongan source code.

Referensi:

* [Laravel Deployment Documentation](https://laravel.com/docs/12.x/deployment)

### Pastikan Document Root Mengarah ke Folder `public`

Struktur yang benar:

```text
/home/user/aplikasi-laravel/
├── app
├── bootstrap
├── config
├── database
├── public
│   └── index.php
├── resources
├── routes
├── storage
├── vendor
└── .env
```

Document root domain harus diarahkan menuju:

```text
/home/user/aplikasi-laravel/public
```

Bukan menuju root project Laravel.

Struktur yang tidak disarankan:

```text
public_html/
├── .env
├── app
├── bootstrap
├── config
├── storage
├── vendor
└── public
```

Jika root project Laravel diletakkan langsung di dalam document root, file sensitif berpotensi terekspos akibat kesalahan konfigurasi web server.

---

## Prioritas 3 — Lindungi Login Laravel

Tambahkan rate limiting khusus pada endpoint login.

Contoh pembatasan:

* Maksimal lima percobaan login per menit.
* Pembatasan berdasarkan kombinasi username dan IP.
* Penambahan delay setelah beberapa kegagalan.
* Lockout sementara setelah banyak kegagalan.
* Pencatatan login gagal.
* Notifikasi login mencurigakan.

Laravel menyediakan:

* `RateLimiter`.
* Middleware `throttle`.
* Named rate limiter.
* Pembatasan berdasarkan IP.
* Pembatasan berdasarkan username atau email.

Referensi:

* [Laravel Routing and Rate Limiting](https://laravel.com/docs/12.x/routing)

Langkah tambahan:

* Aktifkan MFA untuk akun administrator.
* Gunakan password manager.
* Gunakan password unik dan panjang.
* Jangan menggunakan password yang sama dengan akun lain.
* Catat login berhasil dan gagal.
* Simpan IP dan User-Agent login.
* Kirim notifikasi ketika login berasal dari IP atau perangkat baru.
* Gunakan session timeout untuk panel administrator.
* Terapkan authorization berbasis role dan permission.
* Batasi `/admin` berdasarkan VPN atau IP kantor jika memungkinkan.

Mengganti URL `/admin` dapat mengurangi noise scanning, tetapi **tidak boleh dianggap sebagai kontrol keamanan utama**.

Keamanan utama tetap harus menggunakan:

* Autentikasi yang kuat.
* MFA.
* Rate limiting.
* Authorization.
* Session security.
* WAF.
* Monitoring.

---

## Prioritas 4 — Lindungi Hosting cPanel

Lakukan konfigurasi berikut melalui WHM atau cPanel.

### Aktifkan cPHulk Brute Force Protection

cPHulk dapat membantu melindungi:

* cPanel.
* WHM.
* Webmail.
* SSH.
* FTP.
* POP3.
* IMAP.
* SMTP.
* Layanan autentikasi lain pada server.

Konfigurasikan:

* Batas kegagalan login per akun.
* Batas kegagalan login per IP.
* Waktu pemblokiran.
* Pemblokiran permanen untuk serangan berulang.
* Notifikasi administrator.
* Whitelist IP kantor secara hati-hati.

Referensi:

* [cPHulk Brute Force Protection](https://docs.cpanel.net/whm/security-center/cphulk-brute-force-protection/)

### Aktifkan ModSecurity

Gunakan:

* ModSecurity.
* OWASP Core Rule Set.
* Rule khusus Laravel jika diperlukan.
* Logging audit untuk request yang diblokir.

### Aktifkan MFA

Aktifkan MFA untuk:

* WHM.
* cPanel.
* Akun administrator.
* Akun hosting penting.

### Batasi Akses Panel Berdasarkan IP

Apabila memungkinkan, gunakan **Host Access Control** agar layanan berikut hanya dapat diakses dari:

* IP kantor.
* VPN.
* IP administrator.
* Jaringan internal.

Layanan yang perlu dipertimbangkan:

```text
2082 / 2083 — cPanel
2086 / 2087 — WHM
2095 / 2096 — Webmail
22          — SSH
21          — FTP
```

### Periksa Riwayat Login

Periksa:

* IP login.
* Waktu login.
* Username.
* Login berhasil.
* Login gagal.
* Perubahan password.
* Perubahan konfigurasi akun.
* Session yang masih aktif.

---

## Prioritas 5 — Cegah Eksekusi PHP dari Direktori Upload

Jika file publik disimpan melalui symbolic link:

```text
public/storage
```

Pastikan file PHP tidak dapat dieksekusi dari direktori tersebut.

Untuk Apache, dapat dibuat file:

```text
public/storage/.htaccess
```

Dengan isi:

```apache
<FilesMatch "\.(php|phtml|phar|php[0-9]*)$">
    Require all denied
</FilesMatch>
```

Tujuan konfigurasi ini adalah mencegah file berikut dijalankan:

```text
.php
.phtml
.phar
.php5
.php7
.php8
```

Validasi file upload juga harus meliputi:

* MIME type.
* Ekstensi file.
* Ukuran file.
* Signature file.
* Nama file.
* Lokasi penyimpanan.
* Authorization pengguna.
* Antivirus atau malware scanning jika tersedia.

Nama file sebaiknya dibuat ulang oleh aplikasi menggunakan:

* UUID.
* ULID.
* Hash.
* Random filename.

Jangan menggunakan nama file asli pengguna sebagai satu-satunya nama file penyimpanan.

---

## Prioritas 6 — Batasi Scanning Sebelum Mencapai Laravel

Scanning terhadap ratusan URL sebaiknya dihentikan pada lapisan:

* Firewall.
* Reverse proxy.
* Web server.
* WAF.
* CDN.

Tujuannya agar request berbahaya tidak selalu menjalankan PHP dan bootstrapping Laravel.

Terapkan kontrol berikut:

* Rate limit per IP.
* Pemblokiran sementara IP dengan ratusan respons `404`.
* Pemblokiran pola URL berbahaya.
* Challenge untuk trafik mencurigakan.
* Fail2ban.
* ConfigServer Security and Firewall atau CSF.
* Cloudflare WAF.
* WAF institusi.
* IDS atau IPS jika tersedia.

Pola URL yang dapat dipertimbangkan untuk diblokir apabila tidak digunakan:

```text
/wp-content/
/wp-admin/
/wp-includes/
/phpmyadmin
/phpMyAdmin
/adminer
/adminer.php
/WEB-INF/
/solr/
/manager/html
/elmah.axd
/.git/
/.env
/vendor/phpunit/
/cgi-bin/
```

Pola parameter yang perlu dipantau:

```text
../
%2e%2e
/etc/passwd
base64_decode
shell_exec
system(
curl
wget
/bin/sh
mkfifo
interact.sh
oast
```

Laravel juga dapat menggunakan rate limiter yang hanya menghitung respons tertentu, termasuk respons `404`, sehingga cocok untuk mendeteksi enumerasi endpoint.

Referensi:

* [Laravel Routing and Rate Limiting](https://laravel.com/docs/12.x/routing)

---

# Konfigurasi Tambahan Laravel 12

## Batasi Hostname yang Diterima

Secara default, aplikasi dapat menerima request dengan nilai `Host` yang berbeda-beda, tergantung konfigurasi server.

Tambahkan konfigurasi `TrustHosts` pada `bootstrap/app.php`.

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustHosts(
            at: [
                '^bspjiaceh\.kemenperin\.go\.id$',
                '^www\.bspjiaceh\.kemenperin\.go\.id$',
            ],
            subdomains: false
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

Konfigurasi tersebut membatasi hostname yang diterima menjadi:

```text
bspjiaceh.kemenperin.go.id
www.bspjiaceh.kemenperin.go.id
```

Laravel menjelaskan bahwa middleware `TrustHosts` dapat digunakan untuk membatasi hostname yang diterima aplikasi.

Referensi:

* [Laravel HTTP Requests and Trusted Hosts](https://laravel.com/docs/12.x/requests)

---

# Fokus Pemeriksaan Pertama

Pemeriksaan paling mendesak adalah:

1. Memeriksa respons `500` pada **15 Juli 2026 pukul 00.41.36 WIB**.
2. Memeriksa log Laravel pada waktu tersebut.
3. Memeriksa Apache atau Nginx error log.
4. Memeriksa ModSecurity audit log.
5. Memeriksa integritas file pada direktori `public`.
6. Memeriksa integritas file pada `storage/app/public`.
7. Memastikan tidak terdapat file PHP di direktori upload.
8. Memeriksa perubahan source code melalui Git.
9. Memeriksa login cPanel, WHM, SSH, dan FTP.
10. Memastikan `APP_DEBUG=false`.
11. Memastikan document root hanya mengarah ke folder `public`.
12. Mengaktifkan atau meninjau konfigurasi cPHulk dan WAF.

## Perintah Pemeriksaan Awal

```bash
grep -Rni "webtools/control/httpService" storage/logs
```

```bash
grep -Rni "103.134.221.38" storage/logs
```

```bash
grep -Rni "2026-07-15 00:41" storage/logs
```

```bash
find public storage/app/public \
  -type f \
  \( -iname "*.php" -o -iname "*.phtml" -o -iname "*.phar" \) \
  -mtime -2 -ls
```

```bash
git status --short
```

```bash
git diff --stat
```

```bash
composer audit
```

```bash
php artisan route:list --path=admin
```

---

# Kesimpulan Akhir

Website menerima aktivitas scanning dan percobaan eksploitasi otomatis dalam jumlah tinggi.

Aktivitas tersebut mencakup:

* Enumerasi panel administrator.
* Pencarian phpMyAdmin dan Adminer.
* Pencarian webshell.
* Percobaan LFI.
* Percobaan path traversal.
* Percobaan XSS.
* Percobaan command injection.
* Percobaan RCE.
* Percobaan eksploitasi berbagai teknologi yang sebenarnya tidak digunakan oleh aplikasi.

Sebagian besar serangan gagal atau diblokir dengan status `404` dan `403`.

Belum ditemukan bukti kuat bahwa website berhasil diretas. Namun, terdapat beberapa aspek yang memerlukan perhatian segera:

* Endpoint administrator telah teridentifikasi scanner.
* cPanel, WHM, dan Webmail dapat diakses publik.
* Terdapat satu request eksploitasi yang menghasilkan status `500`.
* Terdapat payload LFI yang menerima status `200`, meskipun kemungkinan besar hanya halaman fallback.
* WAF kemungkinan aktif, tetapi perlu ditinjau karena mungkin memblokir crawler yang sah.
* Audit integritas file dan log server tetap wajib dilakukan.

Prioritas utama adalah melakukan verifikasi terhadap error `500`, memeriksa integritas file, memastikan konfigurasi production Laravel telah benar, mengamankan panel hosting, serta menerapkan rate limiting dan perlindungan WAF yang lebih ketat.
