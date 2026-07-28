Berikut adalah dokumentasi komprehensif dari seluruh proses investigasi, analisis, dan strategi remediasi terkait insiden keamanan pada aplikasi web Laravel, tanpa ada pengurangan detail.

### Kesimpulan & Indeks Navigasi

Gunakan daftar kesimpulan berikut untuk menavigasi detail pada dokumen ini:

1. **[Analisis Log & Vektor Awal]**: Server mengalami pemindaian masif; ditemukan eksploitasi *Local File Inclusion* (LFI) via `pearcmd` dan tes injeksi parameter (RCE Echo).
2. **[Identifikasi Vektor Utama]**: Serangan berhasil menembus sistem melalui celah *Unrestricted File Upload*, dibuktikan dengan lolosnya file *webshell* berekstensi `.php7` (seperti `fx1337.php7`).
3. **[Dampak Serangan]**: *Webshell* digunakan untuk mengambil alih server, memodifikasi `.htaccess` (untuk *redirect* trafik/SEO Spam), dan menyisipkan *backdoor* di `index.php`.
4. **[Tindakan Pembersihan Cepat]**: Eksekusi perintah terminal untuk menghapus *webshell*, mengamankan izin direktori (*permissions*), dan memblokir eksekusi PHP di Nginx.
5. **[Strategi Audit Kode dengan AI]**: Menggunakan perintah `grep` untuk melacak fungsi unggahan, dipadukan dengan *prompt engineering* spesifik pada AI Agent di IDE untuk memperbaiki celah validasi ekstensi di Laravel.

---

# Laporan Investigasi dan Remediasi Keamanan Web Laravel

## 1. Analisis Log Akses (Temuan Awal)

Berdasarkan log akses server, aplikasi dihujani pemindaian otomatis (*automated scanning*) oleh botnet. Terdapat beberapa titik masuk kritis yang diincar oleh penyerang:

* **Eksploitasi Local File Inclusion (LFI) ke `pearcmd`:**
Terdapat request berstatus `200 OK` dari IP `36.78.105.198` dengan payload:
`GET /?+config-create+/&lang=../../../../../../../../../../../usr/local/lib/php/pearcmd&/safedog()+6AjaKxPzbF.log HTTP/1.1"`
Serangan ini menyalahgunakan file `pearcmd.php` (sering menargetkan PHP-FPM) untuk menulis file *backdoor* ke dalam direktori web. Ini mengindikasikan konfigurasi `php.ini` memiliki kelemahan jika `register_argc_argv = On`.
* **Verifikasi Remote Code Execution (RCE Echo Test):**
IP `103.134.221.38` melakukan tes injeksi dengan parameter acak:
`GET /?echo+ZpsChxWGOU HTTP/1.1" 200`
Respons sukses dari server menandakan kepada penyerang bahwa mereka memiliki celah eksekusi kode yang berhasil.
* **Pemindaian Webshell (Webshell Scanning):**
Terjadi *bruteforce* massal dari IP *range* `136.144.42.x` dan `172.98.32.x` yang mencari file *backdoor* spesifik seperti `ms-themes.php`, `flower.php`, `akcc.php`, `lufix.php`, dan `txets.php`. Ini menandakan botnet mengenali server tersebut sebagai target yang rentan atau sudah berhasil disusupi.
* **Eksploitasi Fitur Upload:**
Adanya *request* yang menyasar kerentanan *uploader* pihak ketiga (misalnya kerentanan klasik jQuery File Upload) seperti:
`GET /server/php/UploadHandler.php/files/UxuXhKcr.php HTTP/1.1" 404`

## 2. Analisis File Berbahaya & Vektor Utama

Ditemukan file-file anomali di dalam direktori publik, yaitu:

* `gbr2x.php7`
* `fx1337.php7`
* `fx1337.php`
* `nv.php7`

**Analisis Vektor Bypass Ekstensi:**
Penamaan "1337" mengonfirmasi ini adalah *webshell* generik. Kehadiran ekstensi `.php7` menunjukkan bahwa aplikasi memiliki fitur *file upload* dengan filter keamanan yang lemah. Aplikasi kemungkinan menggunakan metode *blacklist* yang hanya memblokir ekstensi `.php` standar. Penyerang membypass ini dengan ekstensi alternatif (`.php7`). Ketika *web server* mengeksekusi `.php7` sebagai skrip yang sah, penyerang mendapatkan akses *webshell* untuk merangkak di dalam sistem.

## 3. Dampak Modifikasi Sistem File Inti

Melalui *webshell* yang berhasil ditanam, penyerang melakukan modifikasi persisten (*SEO Spam Infection* / *Backdoor Persistence*):

* **`.htaccess`**: Diedit untuk merutekan ulang (*redirect*) trafik pengunjung organik aplikasi ke situs berbahaya (judi online atau *phishing*).
* **`index.php`**: Disisipi kode *include* berbahaya di baris paling atas agar *malware* selalu dieksekusi secara tersembunyi setiap kali ada *request* masuk ke aplikasi Laravel.

## 4. Langkah Pembersihan dan Pengamanan Server

Tindakan mitigasi langsung yang harus dijalankan melalui terminal server:

**A. Pencarian dan Penghapusan File Berbahaya**

1. Hapus *webshell* yang telah teridentifikasi:
`sudo rm -f /var/www/html/public/fx1337.php* /var/www/html/public/gbr2x.php7 /var/www/html/public/nv.php7`
2. Cari file injeksi terbaru (3 hari terakhir) di folder publik:
`find /var/www/html/public -type f -mtime -3`
3. Audit direktori *storage* dari ekstensi PHP:
`find /var/www/html/storage/app/public -name "*.php"`

**B. Penguncian Hak Akses (Permissions)**
Pastikan tidak ada folder dengan izin 777.
`sudo find /var/www/html/public -type d -exec chmod 755 {} \;`
`sudo find /var/www/html/public -type f -exec chmod 644 {} \;`

**C. Penambalan Konfigurasi Nginx dan PHP**

1. Matikan `register_argc_argv` di konfigurasi `php.ini` (lokasi umumnya di `/etc/php/8.x/fpm/php.ini` atau `cli/php.ini`).
2. Blokir eksekusi PHP di dalam folder *upload* pada konfigurasi Nginx:
```nginx
location ~* ^/(storage|uploads|assets)/.*\.(php|phps|php5|php7|php8|phtml)$ {
    deny all;
}

```


*Reload* layanan setelahnya: `sudo nginx -t && sudo systemctl reload nginx`.

**D. Pemulihan Sistem**
Timpa file `index.php` dan `.htaccess` yang terinfeksi dengan versi bersih dari *repository* (Git) asli.

## 5. Strategi Audit Kode Menggunakan AI Agent di IDE

Langkah efisien untuk menemukan akar kerentanan kode (*vulnerable endpoint*) di dalam IDE:

**A. Identifikasi Cepat via Terminal**
Gunakan `grep` untuk mempersempit area pencarian pada *controller* yang menangani file *upload*:
`grep -rnw 'app/Http/Controllers/' -e '->file(' -e '->hasFile(' -e '->store(' -e 'move(' -e 'getClientOriginalExtension('`

**B. Prompt Engineering untuk AI Agent**
Arahkan AI Agent di IDE pada file *controller* hasil temuan dengan instruksi teknis:

* *"Tolong review fungsi upload di controller ini. Saya sedang menginvestigasi insiden keamanan di mana attacker berhasil mengunggah file webshell `.php7`. Temukan baris mana yang gagal memvalidasi ekstensi file tersebut."*
* *"Periksa logika penerimaan file di kode ini. Apakah aplikasi ini menggunakan blacklist, atau apakah kode ini mengambil nama/ekstensi file asli menggunakan `getClientOriginalName()` tanpa sanitasi?"*
* *"Tulis ulang blok kode upload ini agar aman dari serangan Unrestricted File Upload. Terapkan validasi `mimes` secara whitelist, simpan menggunakan hash name, dan pastikan disave ke direktori storage yang aman."*

**C. 3 Titik Lemah Klasik Laravel yang Harus Diverifikasi**

1. **Penggunaan `getClientOriginalExtension()`:** Jangan digunakan karena mengambil nama dari input pengguna. Ganti dengan `$file->extension()` yang membaca MIME type asli.
2. **Penyimpanan ke `public_path()`:** Hindari menyimpan *upload* secara langsung ke direktori publik menggunakan nama file asli.
3. **Absennya Validasi *Request*:** Pastikan implementasi metode *whitelist* diterapkan secara ketat sebelum proses simpan (*contoh:* `$request->validate(['dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120']);`).