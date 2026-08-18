# Panduan Modularisasi Landing Page

Panduan ini digunakan untuk memecah section di `resources/views/welcome.blade.php` menjadi anonymous Blade components agar halaman lebih rapi, mudah dirawat, dan tetap mengikuti pola Laravel/TALL Stack.

## Tujuan

Pecah setiap section di `resources/views/welcome.blade.php` menjadi component terpisah di:

```txt
resources/views/components/landing/
```

Pola yang sudah berhasil digunakan:

```blade
<x-landing.hero />

<x-landing.profile
    :profile-images="$profileImages"
    :sejarah-url="$routeOrHash('sejarah-singkat.index')"
/>
```

## Langkah Pemindahan

1. Pilih satu section saja terlebih dahulu.

   Jangan memindahkan banyak section sekaligus. Contoh urutan aman:

   ```txt
   app-showcase
   layanan
   logo-pelanggan
   whatsapp-cta
   sertifikat
   perusahaan-dalam-angka
   testimoni
   peta-pelanggan
   faq
   berita
   ```

2. Buat file component baru dengan nama kebab-case.

   Contoh:

   ```txt
   resources/views/components/landing/sipintu-showcase.blade.php
   resources/views/components/landing/services.blade.php
   resources/views/components/landing/customer-logos.blade.php
   ```

3. Pindahkan markup section secara utuh dari `welcome.blade.php` ke file component.

   Pertahankan semua hal berikut:

   ```txt
   class Tailwind
   id section
   data-aos attribute
   teks
   struktur HTML
   urutan elemen
   komentar yang masih sengaja dipertahankan
   ```

4. Jika section memakai variabel dari `welcome.blade.php`, jadikan props di bagian atas component.

   Contoh:

   ```blade
   @props([
       'sectionSipintu',
       'sipintuDesktopImage',
       'sipintuMobileImage',
   ])
   ```

5. Ganti markup lama di `welcome.blade.php` dengan pemanggilan component.

   Contoh:

   ```blade
   <x-landing.sipintu-showcase
       :section-sipintu="$sectionSipintu"
       :sipintu-desktop-image="$sipintuDesktopImage"
       :sipintu-mobile-image="$sipintuMobileImage"
   />
   ```

6. Ingat aturan konversi nama props.

   Attribute component memakai kebab-case:

   ```blade
   :latest-news="$latestNews"
   ```

   Prop di component memakai camelCase:

   ```blade
   @props(['latestNews'])
   ```

## Rekomendasi Nama Component

Gunakan daftar ini sebagai acuan:

```blade
<x-landing.sipintu-showcase />
<x-landing.services />
<x-landing.customer-logos />
<x-landing.whatsapp-cta />
<x-landing.certificate-lightbox />
<x-landing.certificates />
<x-landing.company-numbers />
<x-landing.testimonials />
<x-landing.customer-map />
<x-landing.faq />
<x-landing.latest-news />
```

## Hal Yang Perlu Dijaga

- Jangan jalankan `npm run build`.
- Jangan ubah logic data preparation di bagian `@php` terlebih dahulu.
- Jangan refactor CSS atau JavaScript dulu.
- Fokus hanya pada pemindahan Blade section.
- Jangan hapus section commented/legacy kecuali memang diminta.
- Jangan ubah tampilan, spacing, warna, teks, atau urutan section.
- Jika patch gagal karena blok terlalu besar, pecah prosesnya:
  - buat file component terlebih dahulu,
  - ganti section lama satu per satu,
  - validasi setelah tiap section.

## Pengecekan Setelah Pemindahan

Jalankan di PowerShell:

```powershell
php artisan view:clear
```

Lalu cek halaman lokal:

```powershell
Invoke-WebRequest -Uri http://bspji-1.test -UseBasicParsing -TimeoutSec 20 | Select-Object -ExpandProperty StatusCode
```

Hasil yang diharapkan:

```txt
200
```

Untuk memastikan konten section masih muncul:

```powershell
$response = Invoke-WebRequest -Uri http://bspji-1.test -UseBasicParsing -TimeoutSec 20
$response.Content.Contains('SIPINTU')
$response.Content.Contains('Layanan Jasa Kami')
```

Hasil ideal:

```txt
True
True
```

## Pengecekan Visual

Buka halaman di browser dan pastikan:

- section tetap muncul di urutan yang sama,
- anchor seperti `#layanan`, `#profil`, dan `#faq` tetap bekerja,
- gambar tetap tampil,
- tombol dan link tidak berubah,
- animasi AOS tetap berjalan,
- tidak ada error Blade seperti `Undefined variable`,
- tidak ada perubahan visual mencolok pada desktop dan mobile.

## Prinsip Kerja

Modularisasi ini adalah refactor struktur, bukan redesign. Jika tampilan berubah, berarti perubahan terlalu luas. Kembalikan fokus ke tujuan utama: memindahkan section ke component tanpa mengubah perilaku halaman.
