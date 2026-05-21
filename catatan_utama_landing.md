# Catatan Utama Modernisasi Landing Page

Dokumen ini merangkum catatan utama untuk meningkatkan kualitas `resources/views/welcome.blade.php` dan component landing page agar lebih sesuai dengan praktik modern Laravel/TALL Stack.

## Status Singkat

Sudah dikerjakan:

- Section awal di `welcome.blade.php` mulai dipecah menjadi Blade components.
- AOS dan Leaflet sudah dipindahkan dari CDN ke dependency npm dan di-load melalui Vite.
- Data preparation landing page sudah dipindahkan dari `welcome.blade.php` ke kelas `App\Support\LandingPageData`.
- CSS inline landing page sudah dipindahkan dari `welcome.blade.php` ke `resources/css/app.css`.

Masih direkomendasikan:

- Memindahkan JavaScript inline ke module JavaScript atau Alpine component.
- Membersihkan section legacy/commented.
- Memperbaiki link placeholder.
- Merapikan interaksi DOM-heavy.

## 1. Data Preparation Masih Terlalu Banyak di Blade

Bagian `@php` di `welcome.blade.php` masih memuat banyak logic presentasi, seperti:

- mapping route layanan,
- mapping icon layanan,
- fallback image,
- transform collection,
- pemanggilan `Storage::url()`,
- pengecekan route dengan `Route::has()`.

Rekomendasi:

- Pindahkan logic tersebut ke route/controller, ViewModel, presenter, atau service kecil.
- Biarkan Blade menerima data siap tampil.
- Blade sebaiknya fokus pada rendering HTML, bukan menyiapkan struktur data.

Contoh arah refactor:

```php
return view('welcome', [
    'profileImages' => $landingData->profileImages(),
    'serviceItems' => $landingData->serviceItems(),
    'faqDisplayImages' => $landingData->faqDisplayImages(),
]);
```

Pembaruan setelah langkah 1:

Status: sudah dikerjakan.

- Membuat kelas `App\Support\LandingPageData` sebagai penyusun data landing page.
- Memindahkan query data utama dari closure route `/` ke `LandingPageData`.
- Memindahkan persiapan URL gambar, fallback image, grouping logo, URL layanan, URL berita, data sertifikat, testimoni, FAQ image, dan data peta pelanggan ke `LandingPageData`.
- Mengubah route `/` agar hanya mengirim data siap tampil ke `welcome.blade.php`.
- Mengubah `welcome.blade.php` dan beberapa component landing aktif agar menerima props siap render, seperti `serviceItems`, `logoItems`, `certificateItems`, `testimonialItems`, dan `latestNewsItems`.

Catatan dokumentasi:

Blade sekarang lebih fokus pada rendering HTML. Logic seperti `Storage::url()`, `Str::slug()`, mapping route layanan, fallback image, dan transform collection dipusatkan di `LandingPageData`, sehingga struktur landing page lebih mudah dirawat dan lebih sesuai dengan praktik Laravel modern.

Rekomendasi lanjutan:

- Pertahankan pola ini untuk refactor berikutnya: siapkan data di class/controller/service, lalu kirim props siap tampil ke Blade.
- Jika data landing bertambah kompleks, `LandingPageData` dapat dipecah lagi menjadi service kecil per section.

Contoh pola yang sekarang digunakan:

```php
Route::get('/', fn (LandingPageData $landingPageData) => view('welcome', $landingPageData->toArray()));
```

## 2. CSS Inline Perlu Dipindahkan

Masih ada blok `<style>` besar di `welcome.blade.php`.

Rekomendasi:

- Pindahkan style custom ke `resources/css/app.css`.
- Jika style hanya dipakai oleh landing page, kelompokkan dengan komentar yang jelas.
- Gunakan Tailwind utilities jika memungkinkan.
- Pertahankan custom CSS hanya untuk kebutuhan yang sulit atau tidak ergonomis dengan utility class, seperti marquee, chart container, atau Leaflet override.

Contoh pengelompokan:

```css
/* Landing: logo marquee */
.logo-marquee {
    position: relative;
    overflow: hidden;
}
```

Pembaruan setelah langkah 2:

Status: sudah dikerjakan.

- Memindahkan blok `<style>` besar dari `resources/views/welcome.blade.php` ke `resources/css/app.css`.
- Mengelompokkan style custom landing page di `resources/css/app.css` dengan komentar `/* Landing page */`.
- Mempertahankan style custom yang memang lebih ergonomis ditulis sebagai CSS biasa, seperti logo marquee, testimonial carousel sizing, certificate card, numbers chart, customer map, tooltip Leaflet, keyframes, dan responsive override.
- Menghapus tag `<style>` dari `welcome.blade.php` agar Blade tidak lagi menyimpan CSS inline halaman.
- Tidak menjalankan `npm run build` karena halaman masih dalam mode pengembangan dan sedang berjalan dengan `npm run dev`.

Catatan dokumentasi:

CSS custom landing page sekarang berada di asset pipeline Vite melalui `resources/css/app.css`. Dengan begitu, `welcome.blade.php` lebih fokus pada struktur HTML dan pemanggilan component, sedangkan styling khusus landing page terkumpul di file CSS utama yang mudah dicari, dikembangkan, dan dikompilasi oleh Vite.

Rekomendasi lanjutan:

- Untuk style custom baru di landing page, tambahkan di bagian `/* Landing page */` pada `resources/css/app.css`.
- Jika style makin besar, pertimbangkan memecahnya ke file CSS khusus landing dan mengimpornya dari `resources/css/app.css`.
- Prioritaskan Tailwind utility class untuk styling yang sederhana, dan gunakan custom CSS hanya untuk pola yang sulit atau kurang ergonomis dengan utility class.

Validasi langkah 2:

```powershell
php artisan view:clear
Invoke-WebRequest -Uri http://bspji-1.test -UseBasicParsing -TimeoutSec 20 | Select-Object -ExpandProperty StatusCode
```

Hasil validasi: halaman lokal mengembalikan status `200`, dan `welcome.blade.php` sudah tidak memiliki tag `<style>`.

## 3. JavaScript Inline Perlu Dipindahkan

Script panjang di bagian bawah `welcome.blade.php` masih menangani:

- certificate lightbox,
- peta pelanggan Leaflet,
- chart SVG,
- format angka,
- DOM query manual.

Rekomendasi:

- Pindahkan script ke `resources/js/app.js` atau file khusus seperti `resources/js/landing.js`.
- Untuk interaksi ringan, gunakan Alpine component.
- Untuk data dari Blade ke JavaScript, gunakan `<script type="application/json">` atau `data-*` attribute agar lebih terstruktur.

Contoh arah struktur:

```txt
resources/js/
├── app.js
└── landing/
    ├── certificate-lightbox.js
    ├── customer-map.js
    └── numbers-chart.js
```

## 4. Section Legacy dan Komentar Panjang Perlu Dibersihkan

Masih ada beberapa blok section lama yang dikomentari.

Rekomendasi:

- Jika sudah tidak dipakai, hapus dari Blade.
- Jika masih dibutuhkan sebagai referensi, pindahkan ke file arsip terpisah.
- Jangan biarkan markup lama yang panjang berada di halaman utama karena memperberat proses maintenance.

Opsi arsip:

```txt
resources/views/components/landing/archive/
```

## 5. Link Placeholder Perlu Diganti

Beberapa tombol masih memakai `href="#"`, terutama pada area SIPINTU.

Risiko:

- UX terlihat belum final.
- Bisa membingungkan pengguna.
- Tidak ideal untuk aksesibilitas dan SEO.

Rekomendasi:

- Ganti dengan route asli jika sudah tersedia.
- Jika belum tersedia, buat konfigurasi URL dari `.env` atau config.
- Jika tombol belum aktif, tampilkan state disabled yang jelas.

Contoh:

```blade
<a href="{{ config('services.sipintu.login_url') }}">
    Login
</a>
```

## 6. Interaksi DOM-Heavy Perlu Dirapikan

Beberapa fitur masih memakai query DOM manual dan manipulasi `innerHTML`.

Area yang perlu dirapikan:

- certificate lightbox,
- chart perusahaan dalam angka,
- customer map,
- carousel testimoni.

Rekomendasi:

- Gunakan Alpine component untuk state UI.
- Pisahkan logic peta dan chart ke module JavaScript.
- Hindari `innerHTML` jika data berasal dari sumber dinamis; gunakan sanitasi atau rendering yang lebih terkendali.

## 7. Component Boundary Perlu Konsisten

Setelah semua section dipindahkan, setiap component sebaiknya punya boundary yang jelas.

Rekomendasi:

- Component hanya menerima props yang dibutuhkan.
- Jangan mengakses variabel global dari parent jika tidak dikirim sebagai props.
- Nama component gunakan kebab-case.
- Nama props di pemanggilan component gunakan kebab-case, sedangkan di `@props` gunakan camelCase.

Contoh:

```blade
<x-landing.latest-news :latest-news="$latestNews" />
```

```blade
@props(['latestNews'])
```

## 8. Urutan Refactor Yang Disarankan

Urutan aman setelah pemecahan Blade components:

1. Selesaikan pemecahan semua section menjadi component.
2. Pindahkan CSS inline ke `resources/css/app.css`.
3. Pindahkan JavaScript inline ke module JavaScript.
4. Pindahkan data preparation dari `welcome.blade.php`.
5. Bersihkan section legacy/commented.
6. Perbaiki link placeholder.
7. Lakukan pengecekan visual desktop dan mobile.

## 9. Checklist Validasi

Setelah setiap tahap refactor, jalankan:

```powershell
php artisan view:clear
```

Cek halaman lokal:

```powershell
Invoke-WebRequest -Uri http://bspji-1.test -UseBasicParsing -TimeoutSec 20 | Select-Object -ExpandProperty StatusCode
```

Hasil yang diharapkan:

```txt
200
```

Pastikan juga secara visual:

- hero tetap tampil,
- semua section tetap berada di urutan yang sama,
- gambar tetap muncul,
- animasi AOS tetap berjalan,
- peta pelanggan tetap tampil,
- tombol dan anchor tetap berfungsi,
- tidak ada error `Undefined variable`,
- tidak ada perubahan layout yang tidak disengaja.

## Prinsip Utama

Modernisasi ini adalah refactor bertahap. Setiap perubahan sebaiknya kecil, mudah dicek, dan tidak mengubah tampilan kecuali memang sedang masuk tahap redesign.
