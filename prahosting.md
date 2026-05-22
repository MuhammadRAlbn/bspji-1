# Catatan Persiapan Hosting (Pra-Hosting) BSPJI Banda Aceh

Dokumen ini berisi catatan penyesuaian dan optimasi yang telah dilakukan pada kode sumber aplikasi untuk keperluan *deployment* ke lingkungan **Shared Hosting**. Catatan ini berguna sebagai referensi jika di masa depan terdapat pengembangan fitur baru agar tetap mengacu pada standar optimasi yang sama.

---

## 1. Pemangkasan Ikon JavaScript (Tree-Shaking)
**Masalah:** Pemanggilan `import { icons } from 'lucide'` mengimpor lebih dari 1.400 ikon sehingga ukuran *bundle* `app.js` menjadi sangat besar (ratusan KB hingga MB).
**Solusi:**
- Di file `resources/js/app.js`, impor telah diubah untuk hanya memanggil ikon yang terdeteksi dipakai di dalam file *Blade templates* (sekitar 24 ikon unik).
- **Aturan ke Depan:** Jika menambahkan ikon Lucide baru di dalam *Blade* (menggunakan atribut `data-lucide="nama-ikon"`), Anda **wajib** mendaftarkan nama ikon tersebut di file `resources/js/app.js` ke dalam blok `import` dan objek `usedIcons`.

## 2. Pemisahan Vendor (Vite Chunk Splitting)
**Masalah:** Menggabungkan pustaka pihak ketiga (*library*) seperti Leaflet, AOS, dan AlpineJS ke dalam satu file JS aplikasi utama memperlambat *loading* dan membuat seluruh file terunduh ulang meski hanya mengganti teks sederhana.
**Solusi:**
- Menambahkan opsi `manualChunks` di `vite.config.js` untuk memisah `vendor-alpine`, `vendor-aos`, `vendor-leaflet`, dan `vendor-lucide`.
- Pustaka pihak ketiga ini akan tersimpan lama di *cache browser* pengguna.

## 3. Optimasi Media (Lazy Loading & Preload)
**Solusi yang Diterapkan:**
- **Video Hero (`hero.blade.php`):** Ditambahkan atribut `preload="metadata"` agar *browser* tidak langsung mengunduh ukuran penuh file video saat halaman baru dimuat, melainkan hanya ukuran dasarnya saja.
- **Gambar LCP (*Largest Contentful Paint*):** Diberikan atribut `fetchpriority="high"` untuk gambar slide hero agar dimuat paling awal.
- **Gambar Pendukung:** Diberikan atribut `loading="lazy"` pada file *Blade* komponen seperti FAQ, News, Layanan, dan Logo Pelanggan.
- **Aturan ke Depan:** Selalu gunakan `loading="lazy"` untuk gambar-gambar besar/banyak yang berada di luar area yang langsung terlihat layar (*below the fold*).

## 4. Pola Caching Aplikasi (Backend)
**Masalah:** Lingkungan *Shared Hosting* tidak selalu dilengkapi fitur *Redis* atau *Memcached*, namun halaman beranda mengeksekusi lebih dari 8 *query* basis data (*database*) untuk fitur-fitur seperti Logo, Berita, Layanan, dsb.
**Solusi:**
- Mengimplementasikan `Cache::flexible()` di `app/Support/LandingPageData.php`.
- Menggunakan pendekatan *Stale-while-revalidate*: saat kedaluwarsa (setelah 5 menit), data yang ada tetap ditampilkan (tanpa hambatan pemuatan), dan pembaruan akan otomatis berjalan di proses latar belakang (*background*). Data akan disimpan menggunakan mode *File Cache*.

## 5. Konfigurasi Server Apache (`.htaccess`)
**Solusi yang Diterapkan:**
- Sebuah file khusus bernama `.htaccess` telah diletakkan di dalam folder `/public`.
- Mengaktifkan `mod_deflate` untuk kompresi *Gzip* (mengecilkan lalu lintas pertukaran teks dan HTML hingga 70%).
- Mengaktifkan `mod_expires` dan *Cache-Control* `immutable` untuk memaksimalkan *cache* *browser* (1 tahun) pada file statis berlabel unik (*hash* dari Vite) seperti gambar dan CSS/JS.
- Menambah lapisan proteksi HTTP *Headers* seperti perlindungan `X-XSS` dan `X-Frame-Options` (mencegah *Clickjacking*).

## 6. SEO Meta Tag & Robots.txt
- Ditambahkan tag komprehensif *Open Graph* (OG) di file `welcome.blade.php` dan `app.blade.php` (*layout* utama) agar URL yang dibagikan tampil sempurna.
- Tautan pemanasan (*Preconnect*) untuk Google Fonts diletakkan di `<head>` untuk mendahului DNS lookup sebelum pemanggilan `css` yang memuat tautan jenis *font*.
- File `public/robots.txt` ditambahkan guna menghentikan sistem *crawling* Google menuju halaman admin (`/admin`) serta direktori cadangan (`/storage/`).

## 7. Acuan .env Production
- File `.env.example` telah diisi panduan siap *deploy*. 
- Catatan mode produksi: Ganti log menjadi `LOG_LEVEL=error`, singkirkan `APP_DEBUG=true` (menjadi `false`), dan nyalakan enkripsi *cookie*.

---

### Perintah Pendelegasian Kode (Deployment) ke CPanel
Saat *deploy* file atau *commit git* yang memuat perubahan di atas ditarik oleh hosting utama, Anda hanya perlu menjalankan:

```bash
composer install --optimize-autoloader --no-dev
php artisan storage:link
php artisan optimize:clear
php artisan optimize
php artisan view:cache
```

***Catatan Akhir:** Pastikan pengaturan dokumen `DocumentRoot` pada pengaturan domain utama (cPanel) telah secara benar diarahkan langsung masuk menunjuk ke `bspji-1/public` dan BUKAN di *root* instalasi Laravel.*
