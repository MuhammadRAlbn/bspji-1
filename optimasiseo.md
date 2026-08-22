# Audit dan Roadmap Optimasi SEO BSPJI Banda Aceh

> **Tanggal audit:** 22 Agustus 2026  
> **Domain utama yang diaudit:** `https://bspjiaceh.kemenperin.go.id`  
> **Target utama:** pencarian “BSPJI Banda Aceh” dan “BSPJI Aceh”  
> **Target sekunder:** pencarian layanan pengujian, kalibrasi, sertifikasi produk, pemeriksaan halal, industri hijau, TKDN, pelatihan teknis, dan konsultansi  
> **Jenis dokumen:** audit berbukti, roadmap, dan status implementasi repository

## Status Implementasi Repository

Pembaruan ini mencatat pekerjaan lokal pada 22 Agustus 2026. Status produksi tetap mengikuti hasil audit sampai perubahan di-deploy dan diverifikasi melalui HTTP serta Google Search Console.

| Pekerjaan | Status repository | Status produksi |
|---|---|---|
| Sitemap XML dinamis native Laravel | Selesai | Menunggu deployment; produksi masih 404 pada waktu audit |
| Cache sitemap satu jam dan invalidasi saat berita berubah | Selesai | Menunggu deployment |
| Filter hanya berita yang sudah terbit | Selesai dan teruji | Menunggu deployment |
| URL canonical sitemap dari `APP_URL` | Selesai dan teruji | Wajib memastikan `APP_URL=https://bspjiaceh.kemenperin.go.id` saat deployment |
| Referensi sitemap pada `robots.txt` | Sudah mengarah ke URL canonical | Baru efektif setelah endpoint sitemap di-deploy |
| Title “BSPJI Pekanbaru” pada dua halaman layanan | Sudah diganti menjadi “BSPJI Banda Aceh” | Menunggu deployment |

File implementasi utama:

- `routes/web.php`;
- `app/Http/Controllers/SitemapController.php`;
- `app/Support/SitemapUrlProvider.php`;
- `app/Observers/NewsObserver.php`;
- `resources/views/sitemap.blade.php`;
- `tests/Feature/SitemapTest.php`.

Keputusan sitemap v1 tetap memasukkan empat kategori detail informasi publik. Dua kategori, `serta_merta` dan `dikecualikan`, saat ini hanya menampilkan “Belum Ada Data”. Jika halaman kosong tersebut memang tidak ditujukan untuk hasil pencarian, keluarkan keduanya dari provider sitemap sampai tersedia konten yang bermakna; pengecualian dari sitemap saja bukan pengganti kebijakan canonical/noindex.

## 1. Ringkasan Eksekutif

Website produksi dapat diakses melalui HTTPS dan halaman publik utama sudah memiliki fondasi dasar SEO berupa `<title>`, meta description, meta robots, canonical, struktur heading, serta konten nama lembaga. Namun, situs **belum siap disebut optimal untuk proses crawling dan indexing** karena masih terdapat masalah teknis berprioritas tinggi.

Masalah paling mendesak adalah:

1. `robots.txt` mengarahkan crawler ke `/sitemap.xml`, tetapi URL tersebut mengembalikan **404**.
2. Versi HTTP dan host `www` masih memberikan respons **200**, bukan redirect permanen ke HTTPS non-www. Setiap versi juga menghasilkan self-canonical sendiri sehingga sinyal URL terpecah.
3. HTTPS pada host `www` mengalami ketidakcocokan nama sertifikat.
4. HTML produksi menggunakan `lang="en"`, padahal isi situs berbahasa Indonesia.
5. Dua halaman layanan masih memakai title **“BSPJI Pekanbaru”**.
6. Hampir semua halaman memakai meta description generik yang sama.
7. Lima URL profil menyajikan hampir seluruh konten yang sama dan masing-masing memiliki self-canonical berbeda.
8. Belum ada structured data JSON-LD, Twitter Card, dan metadata sosial lengkap per halaman.

> Daftar di atas adalah kondisi produksi yang terkonfirmasi saat audit. Sitemap dan koreksi nama Pekanbaru sudah diselesaikan di repository, tetapi belum boleh dianggap selesai di produksi sebelum deployment.

Kondisi tersebut tidak berarti Google pasti menolak situs, tetapi mengurangi kejelasan identitas, struktur, URL utama, dan prioritas halaman bagi mesin pencari. Target merek “BSPJI Banda Aceh” memiliki peluang yang baik karena nama lembaga sudah muncul secara konsisten pada homepage, heading, isi, dan footer. Perbaikan P0 dan P1 perlu dilakukan sebelum kampanye konten atau optimasi kata kunci lebih luas.

> **Catatan penting:** SEO tidak dapat menjamin posisi tertentu di Google. Implementasi yang benar membuat situs layak dirayapi, dipahami, dan dipertimbangkan untuk indeks. Status indeks aktual dan performa query hanya dapat dipastikan melalui Google Search Console.

## 2. Metodologi dan Batas Audit

Audit dilakukan dengan:

- meninjau route publik, controller, model berita, konfigurasi Laravel, layout Blade, halaman layanan, dan konfigurasi web server;
- memeriksa metadata pada 19 URL publik yang mewakili homepage, profil, layanan, berita, informasi publik, dan kontak;
- memeriksa respons HTTP produksi, `robots.txt`, sitemap, varian protokol/host, favicon, dan respons menggunakan user-agent Googlebot;
- memindai aset frontend, ukuran file besar, serta penggunaan atribut gambar;
- meninjau baseline feature test yang sudah ada pada proyek;
- membandingkan rekomendasi dengan dokumentasi resmi Google Search Central.

Audit ini memiliki batasan berikut:

- tidak memiliki akses ke Google Search Console, sehingga jumlah halaman terindeks, alasan pengecualian, query, impression, click, CTR, dan posisi rata-rata belum dapat dipastikan;
- tidak memiliki akses ke pengelolaan DNS, sertifikat TLS, Google Business Profile, atau konfigurasi LiteSpeed di luar repository;
- PageSpeed Insights API tidak menghasilkan skor karena kuota layanan tidak tersedia saat pemeriksaan; risiko performa pada dokumen ini berasal dari inspeksi aset dan markup, bukan skor Lighthouse aktual;
- pencarian `site:` di mesin pencari hanya merupakan indikasi dan tidak digunakan sebagai bukti final status indeks.

## 3. Status Produksi yang Terkonfirmasi

Pemeriksaan dilakukan pada 22 Agustus 2026.

| Pemeriksaan | Hasil | Status |
|---|---|---|
| `https://bspjiaceh.kemenperin.go.id/` | `200 OK` | Baik |
| `https://bspjiaceh.kemenperin.go.id/robots.txt` | `200 OK`, `text/plain` | Baik, tetapi referensi sitemap rusak |
| `https://bspjiaceh.kemenperin.go.id/sitemap.xml` | `404 Not Found` | Kritis |
| Homepage dengan user-agent Googlebot | `200 OK` | Baik |
| `robots.txt` dengan user-agent Googlebot | `200 OK` | Baik |
| Sitemap dengan user-agent Googlebot | `404 Not Found` | Kritis |
| `http://bspjiaceh.kemenperin.go.id/` | `200 OK`, tanpa redirect | Kritis |
| `http://www.bspjiaceh.kemenperin.go.id/` | `200 OK`, tanpa redirect | Kritis |
| `https://www.bspjiaceh.kemenperin.go.id/` | Sertifikat tidak cocok dengan hostname | Kritis |
| Canonical pada HTTPS non-www | HTTPS non-www | Baik hanya untuk request ini |
| Canonical pada HTTP non-www | HTTP non-www | Salah |
| Canonical pada HTTP www | HTTP www | Salah |
| Bahasa dokumen produksi | `<html lang="en">` | Salah untuk konten Indonesia |
| Favicon produksi | `200 OK`, `Content-Length: 0` | Rusak |
| Homepage | 1 title, 1 description, 1 canonical, 1 H1, 5 tag OG, 0 JSON-LD | Sebagian baik |
| 18 halaman publik selain homepage | Metadata dasar tersedia, description sama, OG 0, JSON-LD 0 | Perlu perbaikan |

## 4. Definisi Prioritas

| Prioritas | Arti | Target pengerjaan |
|---|---|---|
| **P0** | Menghambat atau membingungkan crawling, indexing, canonicalization, atau identitas utama | Sebelum optimasi konten lain |
| **P1** | Berdampak tinggi pada relevansi, snippet, struktur entitas, dan duplikasi halaman | Segera setelah P0 |
| **P2** | Meningkatkan kualitas konten, performa, aksesibilitas, dan stabilitas teknis | Setelah fondasi P0–P1 stabil |
| **P3** | Operasional SEO, monitoring, dan pengembangan jangka menengah | Berkelanjutan |

## 5. Temuan P0 — Harus Diperbaiki Terlebih Dahulu

### P0-01 — Sitemap dinyatakan di robots.txt tetapi tidak tersedia

**Jenis:** fakta terkonfirmasi  
**Status repository:** selesai diimplementasikan; menunggu deployment dan verifikasi Search Console  
**Bukti:**

- `public/robots.txt` mencantumkan `Sitemap: https://bspjiaceh.kemenperin.go.id/sitemap.xml`;
- pada snapshot repository saat audit, belum terdapat file `public/sitemap.xml`, route sitemap, controller sitemap, atau generator sitemap; route, controller, provider, dan view XML sekarang sudah ditambahkan secara lokal;
- produksi mengembalikan `404 Not Found` untuk `/sitemap.xml`, termasuk ketika diperiksa dengan user-agent Googlebot.

**Dampak:** Google kehilangan daftar eksplisit URL canonical yang seharusnya dirayapi. Hal ini sangat merugikan halaman berita baru dan halaman yang internal link-nya tidak kuat.

**Rekomendasi implementasi:**

1. Tambahkan route bernama `sitemap` untuk `GET /sitemap.xml`.
2. Gunakan controller/action khusus yang mengembalikan XML dengan `Content-Type: application/xml; charset=UTF-8`.
3. Isi sitemap dengan URL absolut HTTPS non-www:
   - homepage;
   - lima halaman profil setelah kontennya dibuat unik;
   - seluruh halaman layanan;
   - UPP, PPID, informasi publik, empat detail informasi yang valid, berita, kontak, dan zona integritas;
   - hanya detail berita yang lolos scope `News::published()`.
4. Kecualikan admin, API, route POST, health check `/up`, pengaduan, hasil/bukti pengaduan, download dokumen, draft/future news, serta URL berparameter pencarian/filter.
5. Gunakan `updated_at` atau tanggal perubahan nyata sebagai `lastmod`; jangan mengarang tanggal perubahan.
6. Cache hasil sitemap selama satu jam dan hapus cache ketika berita diterbitkan, diperbarui, atau dihapus.
7. Pertahankan satu baris `Sitemap:` pada `robots.txt` yang mengarah ke domain canonical.

**Kriteria selesai:**

- `/sitemap.xml` memberikan `200 OK` dan XML valid;
- semua `<loc>` memakai `https://bspjiaceh.kemenperin.go.id`;
- URL draft, private, download, dan admin tidak ditemukan;
- sitemap berhasil dikirim dan dibaca oleh Search Console tanpa error.

### P0-02 — HTTP/www tidak diarahkan dan canonical dapat berubah mengikuti request

**Jenis:** fakta terkonfirmasi  
**Bukti:**

- HTTP non-www dan HTTP www memberikan `200 OK`, bukan `301`/`308`;
- HTTPS www gagal validasi sertifikat hostname;
- `resources/views/components/layouts/app.blade.php` memakai `url()->current()` untuk canonical;
- `public/.htaccess` hanya menangani trailing slash dan front controller, tanpa normalisasi protokol/host.

**Dampak:** konten yang sama tersedia pada beberapa origin. Google harus memilih sendiri URL canonical dan sinyal link dapat terpecah. HTTPS www bahkan tidak dapat menerima redirect yang dipercaya browser sebelum masalah sertifikat diselesaikan, karena negosiasi TLS terjadi sebelum redirect HTTP.

**Rekomendasi implementasi:**

1. Tetapkan origin tunggal: `https://bspjiaceh.kemenperin.go.id`.
2. Pasang sertifikat yang mencakup `bspjiaceh.kemenperin.go.id` dan `www.bspjiaceh.kemenperin.go.id`.
3. Di LiteSpeed/Apache atau reverse proxy, arahkan semua HTTP dan semua host www ke HTTPS non-www dengan redirect permanen `301`, sambil mempertahankan path dan query string.
4. Set produksi `APP_URL=https://bspjiaceh.kemenperin.go.id`.
5. Konfigurasikan trusted proxy bila TLS dihentikan pada proxy/load balancer agar Laravel mengenali scheme HTTPS dengan benar.
6. Bangun canonical dari base URL tepercaya di konfigurasi SEO, bukan dari host bebas pada request.
7. Aktifkan HSTS hanya setelah HTTPS dan semua subdomain yang relevan sudah dipastikan aman.

**Kriteria selesai:**

- ketiga varian alternatif mengembalikan satu redirect permanen menuju URL HTTPS non-www yang setara;
- HTTPS www tidak menampilkan error sertifikat;
- canonical selalu memakai HTTPS non-www;
- tidak ada redirect chain atau loop.

### P0-03 — Dua title salah menyebut BSPJI Pekanbaru

**Jenis:** fakta terkonfirmasi  
**Status repository:** selesai diperbaiki dan dilindungi oleh feature test; menunggu deployment  
**Bukti:**

- pada snapshot saat audit, `resources/views/sertifikasi-produk.blade.php` menggunakan `Sertifikasi Produk - BSPJI Pekanbaru`;
- pada snapshot saat audit, `resources/views/konsultasi-pendampingan.blade.php` menggunakan `Konsultansi dan Pendampingan - BSPJI Pekanbaru`; keduanya sekarang sudah diperbaiki secara lokal.

**Dampak:** title bertentangan langsung dengan target merek dan lokasi. Ini dapat membingungkan pengguna, mesin pencari, dan tampilan saat URL dibagikan.

**Rekomendasi:** ganti seluruh referensi publik “BSPJI Pekanbaru” menjadi “BSPJI Banda Aceh”, lalu lakukan pencarian repository dan inspeksi HTML produksi untuk memastikan tidak ada sisa identitas yang salah.

**Kriteria selesai:** pencarian `rg -i "Pekanbaru" resources/views` tidak menghasilkan referensi publik dan title produksi kedua halaman memakai BSPJI Banda Aceh.

### P0-04 — Bahasa dokumen produksi salah

**Jenis:** fakta terkonfirmasi  
**Bukti:**

- layout membentuk atribut bahasa dari `app()->getLocale()`;
- HTML produksi menghasilkan `<html lang="en">`;
- `.env.example` masih menetapkan `APP_LOCALE=en` dan `APP_FALLBACK_LOCALE=en`.

**Dampak:** sinyal bahasa tidak sesuai dengan isi halaman berbahasa Indonesia dan dapat mengganggu aksesibilitas, pembacaan layar, serta pemahaman bahasa oleh crawler.

**Rekomendasi:** gunakan `APP_LOCALE=id` pada produksi dan `.env.example`; gunakan fallback `id` bila situs memang hanya berbahasa Indonesia. `hreflang` belum diperlukan selama tidak ada versi bahasa lain.

**Kriteria selesai:** seluruh halaman publik produksi menghasilkan `<html lang="id">`.

## 6. Temuan P1 — Dampak Tinggi

### P1-01 — Meta description generik dipakai hampir di semua halaman

**Jenis:** fakta terkonfirmasi  
**Bukti:** `resources/views/components/layouts/app.blade.php` menyediakan description default dan hanya homepage yang memasok description khusus. Sampel 18 halaman publik lain menghasilkan description yang sama.

**Dampak:** snippet tidak menjelaskan isi khusus halaman dan sulit membedakan layanan di hasil pencarian.

**Rekomendasi:** setiap halaman indeks penting wajib memasok title dan description unik. Detail berita memakai `excerpt` yang dipotong secara aman sebagai description. Jangan menambahkan meta keywords karena Google tidak menggunakannya untuk ranking web.

**Kriteria selesai:** tidak ada duplicate description pada URL penting, setiap description relevan dengan isi halaman, dan tidak ada description kosong.

### P1-02 — Lima URL profil memiliki konten dan metadata hampir identik

**Jenis:** fakta terkonfirmasi  
**Bukti:**

- route `/sejarah-singkat`, `/visi-misi`, `/tugas-fungsi`, `/struktur-organisasi`, dan `/profil-pejabat` semuanya menuju `ProfilController@index`;
- controller memuat seluruh dataset profil untuk setiap URL;
- `resources/views/profil.blade.php` merender seluruh section ke HTML lalu hanya mengatur tampilan menggunakan `x-show`;
- semua URL memakai title `Tentang Kami - BSPJI Banda Aceh`, H1 `Tentang Kami`, description yang sama, dan self-canonical berbeda.

**Dampak:** lima URL bersaing dengan isi sangat mirip dan mesin pencari sulit menentukan relevansi masing-masing URL.

**Keputusan roadmap:** pertahankan lima URL deskriptif, tetapi server-render hanya section yang sesuai dengan URL aktif. Berikan title, description, H1, breadcrumb, dan isi utama yang unik pada setiap URL. Navigasi tab harus tetap berupa anchor normal yang dapat diikuti crawler; JavaScript boleh memperkaya transisi tetapi tidak boleh menjadi satu-satunya mekanisme navigasi.

**Kriteria selesai:** HTML tanpa JavaScript pada setiap URL hanya berisi konten utama section terkait, metadata berbeda, H1 spesifik, dan self-canonical benar.

### P1-03 — Canonical pagination membuang parameter halaman

**Jenis:** fakta terkonfirmasi  
**Bukti:** canonical memakai `url()->current()`, sedangkan berita menggunakan `?page=` dan direktori sertifikasi menggunakan `?direktori_page=`.

**Dampak:** halaman 2 dan seterusnya menunjuk ke halaman pertama sebagai canonical sehingga item yang hanya terdapat pada halaman lanjutan dapat kurang mudah ditemukan.

**Keputusan canonical:**

- `/berita?page=2` dan seterusnya harus self-canonical dengan parameter `page`;
- `/sertifikasi-produk?direktori_page=2` dan seterusnya harus self-canonical dengan `direktori_page`;
- parameter tracking seperti `utm_*`, `fbclid`, dan `gclid` dibuang dari canonical;
- hasil pencarian/filter internal seperti `direktori_search` diberi `noindex,follow` dan canonical ke halaman direktori tanpa parameter pencarian;
- halaman pertama memakai URL bersih tanpa `?page=1`.

**Kriteria selesai:** setiap halaman pagination memiliki canonical unik yang sesuai dan URL tracking tidak membuat canonical baru.

### P1-04 — Structured data belum tersedia

**Jenis:** fakta terkonfirmasi  
**Bukti:** tidak ditemukan `application/ld+json` atau schema.org pada layout dan halaman publik yang diperiksa.

**Rekomendasi JSON-LD:**

- homepage: `GovernmentOrganization` dan `WebSite`;
- halaman internal: `BreadcrumbList` sesuai navigasi yang terlihat;
- detail berita: `NewsArticle` dengan `headline`, `description`, `image`, `datePublished`, `dateModified`, `mainEntityOfPage`, dan `publisher`;
- data organisasi minimal: `name`, `alternateName` (`BSPJI Aceh`), `url`, `logo`, alamat lengkap, telepon, email resmi yang sudah diverifikasi, dan `sameAs` untuk akun sosial resmi.

JSON-LD harus menggambarkan konten yang benar-benar terlihat oleh pengguna. Jangan membuat rating, review, jam layanan, atau klaim akreditasi yang tidak dapat dibuktikan.

**Kriteria selesai:** tidak ada error kritis pada Rich Results Test atau Schema Markup Validator dan nilai schema konsisten dengan konten halaman.

### P1-05 — Open Graph tidak lengkap dan tidak ada Twitter Card

**Jenis:** fakta terkonfirmasi  
**Bukti:** homepage memiliki lima tag OG, tetapi tidak memiliki `og:image` dan `og:site_name`; halaman lain tidak memiliki OG; tidak ditemukan Twitter Card.

**Rekomendasi:** perluas komponen layout dengan interface SEO terpusat:

- `title`;
- `description`;
- `canonical`;
- `robots`;
- `ogType`;
- `ogImage`;
- `structuredData`.

Render minimal `og:type`, `og:title`, `og:description`, `og:url`, `og:image`, `og:locale`, `og:site_name`, `twitter:card`, `twitter:title`, `twitter:description`, dan `twitter:image`. Gunakan gambar default 1200×630 untuk halaman tanpa cover; berita menggunakan cover masing-masing.

**Kriteria selesai:** setiap halaman utama menghasilkan metadata sosial lengkap dan preview dapat dibaca oleh Facebook Sharing Debugger serta validator sosial yang relevan.

### P1-06 — Favicon kosong

**Jenis:** fakta terkonfirmasi  
**Bukti:** `public/favicon.ico` berukuran 0 byte dan produksi memberikan `Content-Length: 0`.

**Dampak:** identitas tab browser dan favicon hasil pencarian tidak dapat tampil dengan benar.

**Rekomendasi:** sediakan favicon valid dengan ukuran kelipatan 48 px, `apple-touch-icon` 180×180, serta PNG 192×192 dan 512×512 untuk manifest. Tambahkan link eksplisit di `<head>` dan gunakan logo resmi dengan kontras yang jelas.

**Kriteria selesai:** favicon memiliki isi valid, dapat diakses `200 OK`, dan ditampilkan browser tanpa error.

### P1-07 — Data kontak belum konsisten

**Jenis:** perlu verifikasi pemilik situs  
**Bukti:** footer menampilkan `bspjiaceh@gmail.com`, sedangkan halaman kontak menampilkan `bspjiaceh@kemenperin.go.id`. Alamat dan telepon relatif konsisten.

**Dampak:** inkonsistensi nama/alamat/telepon/email dapat melemahkan kejelasan entitas dan kepercayaan pengguna.

**Rekomendasi:** tentukan email resmi yang disetujui instansi—secara default prioritaskan domain `kemenperin.go.id` bila memang aktif—lalu samakan footer, kontak, JSON-LD, profil sosial, dan Google Business Profile/Maps.

**Kriteria selesai:** data NAP dan kontak identik pada seluruh kanal resmi.

### P1-08 — Kontrol indeks untuk halaman nonpublik belum eksplisit

**Jenis:** risiko teknis  
**Bukti:** `robots.txt` melarang `/admin` dan `/livewire`, tetapi route health `/up` tersedia dan tidak ada kebijakan `X-Robots-Tag` yang terpusat untuk halaman/utilitas atau file tertentu.

**Rekomendasi:**

- pertahankan autentikasi sebagai perlindungan utama admin/private content;
- gunakan `noindex` atau `X-Robots-Tag: noindex` untuk endpoint utilitas yang dapat diakses publik tetapi tidak layak muncul di hasil pencarian;
- tentukan kebijakan untuk PDF publik: indeks bila dokumen memang menjadi sumber informasi publik, atau beri `X-Robots-Tag: noindex` bila hanya lampiran operasional;
- jangan mengandalkan `robots.txt` sebagai alat penghapusan indeks karena crawler harus dapat membaca `noindex`.

## 7. Temuan P2 — Kualitas, Konten, dan Performa

### P2-01 — Risiko Core Web Vitals pada homepage

**Jenis:** risiko berdasarkan inspeksi aset; perlu pengukuran lapangan  
**Bukti:**

- video hero `public/video/videocrop.webm` sekitar 5,76 MB;
- bundle utama JavaScript sekitar 288 KB, CSS sekitar 150 KB, dan vendor Leaflet JavaScript sekitar 145 KB sebelum transfer compression;
- halaman utama memuat font Google dan beberapa library frontend;
- HTML dinamis dikirim dengan `Cache-Control: no-cache, no-store, must-revalidate`.

**Rekomendasi:**

1. Ukur mobile dan desktop dengan PageSpeed Insights, Lighthouse, serta laporan Core Web Vitals Search Console.
2. Sediakan poster hero terkompresi dan hindari mengunduh video penuh sebelum diperlukan; pertimbangkan versi video lebih kecil untuk mobile.
3. Pisahkan Leaflet dan kode peta dari bundle awal agar hanya dimuat pada halaman/section yang memerlukan.
4. Kurangi JavaScript yang tidak dipakai, evaluasi AOS/Lucide/Leaflet per halaman, dan pertahankan code splitting Vite.
5. Self-host font atau kurangi kombinasi family/weight bila hasil pengukuran menunjukkan font menghambat render.
6. Gunakan cache respons HTML pendek atau conditional caching yang aman untuk halaman publik, tanpa menyimpan respons personal/form.

**Target:** LCP ≤2,5 detik, INP <200 ms, dan CLS <0,1 pada persentil ke-75 data lapangan.

### P2-02 — Dimensi dan alt gambar belum konsisten

**Jenis:** fakta dari static source scan seluruh view Blade  
**Bukti:** ditemukan 101 tag `<img>` di seluruh view Blade; tidak ada yang memiliki atribut HTML `width` dan `height`, hanya 15 yang eksplisit `loading="lazy"`, dan 44 tidak memiliki atribut `alt` eksplisit pada source statis.

**Catatan:** sebagian gambar menggunakan binding Alpine atau data dinamis sehingga temuan harus diverifikasi pada HTML hasil render. Gambar dekoratif boleh memakai `alt=""`.

**Rekomendasi:**

- berikan `width` dan `height` sesuai rasio intrinsik untuk mengurangi layout shift;
- gunakan alt deskriptif untuk gambar informatif, nama/jabatan untuk profil, judul untuk berita, dan `alt=""` untuk dekorasi;
- lazy-load gambar di bawah fold, tetapi jangan lazy-load gambar LCP;
- gunakan `fetchpriority="high"` hanya untuk kandidat LCP yang benar;
- pertahankan WebP/AVIF dan `srcset`/`sizes` untuk gambar responsif.

### P2-03 — Judul halaman layanan belum konsisten

**Jenis:** fakta terkonfirmasi  
**Bukti:** halaman pengujian hanya menggunakan title `Pengujian` dan kalibrasi hanya `Layanan Kalibrasi`, sementara halaman lain menyertakan brand.

**Rekomendasi:** gunakan pola `Topik utama | BSPJI Banda Aceh` dengan bahasa alami dan hindari pengulangan kata kunci. H1 harus menjelaskan layanan, sedangkan title boleh menambahkan brand.

### P2-04 — Stabilitas URL berita belum dijaga

**Jenis:** risiko arsitektur  
**Bukti:** detail berita menggunakan slug dan slug dapat diedit dari admin, tetapi tidak ada histori slug atau redirect URL lama.

**Dampak:** perubahan slug setelah artikel terindeks membuat backlink dan hasil pencarian lama menuju 404.

**Rekomendasi:** kunci slug setelah berita dipublikasikan atau simpan histori slug dan lakukan redirect `301` ke slug terbaru.

### P2-05 — Struktur semantik profil perlu dirapikan

**Jenis:** fakta source  
**Bukti:** layout utama sudah membungkus slot dengan `<main>`, sedangkan halaman profil memiliki elemen `<main>` lain di dalamnya.

**Rekomendasi:** gunakan satu `<main>` per dokumen dan ubah container dalam halaman profil menjadi `section` atau `div` yang tepat.

### P2-06 — Halaman Zona Integritas belum memiliki H1

**Jenis:** fakta source  
**Bukti:** judul utama Zona Integritas pada `resources/views/components/zona-integritas/section.blade.php` masih menggunakan `<h2>`, dan tidak ditemukan H1 pada halaman tersebut.

**Dampak:** hierarki heading tidak memiliki judul utama yang eksplisit untuk pengguna, teknologi bantu, dan mesin pencari.

**Rekomendasi:** gunakan satu H1 yang menjelaskan “Zona Integritas BSPJI Banda Aceh” pada halaman penuh `/zona-integritas`. Ketika section yang sama ditampilkan sebagai cuplikan di homepage, izinkan level heading disesuaikan melalui prop komponen agar homepage tetap hanya memiliki satu H1.

**Kriteria selesai:** homepage dan halaman Zona Integritas masing-masing mempunyai tepat satu H1 tanpa menduplikasi heading utama.

### P2-07 — Konten dan internal linking perlu diarahkan ke intent pencarian

**Jenis:** peluang optimasi  
**Rekomendasi:**

- homepage menjelaskan secara ringkas bahwa BSPJI Banda Aceh adalah unit layanan standardisasi dan jasa industri di Aceh;
- setiap halaman layanan menjawab siapa pengguna layanan, ruang lingkup, proses, dokumen, tarif, waktu, standar/akreditasi yang dapat dibuktikan, area layanan, dan CTA;
- berita relevan menautkan secara kontekstual ke halaman layanan, bukan hanya ke beranda;
- halaman layanan menautkan ke kontak/form resmi dan berita/studi kasus terkait;
- gunakan “BSPJI Aceh” sebagai variasi nama secara alami pada copy atau `alternateName`, bukan diulang secara berlebihan.

## 8. Matriks Kata Kunci dan Halaman Tujuan

| Kelompok pencarian | Halaman tujuan | Rekomendasi title | Tujuan konten |
|---|---|---|---|
| bspji banda aceh, bspji aceh | `/` | `BSPJI Banda Aceh | Layanan Standardisasi dan Jasa Industri` | Memastikan homepage menjadi hasil utama merek |
| profil bspji banda aceh, sejarah bspji aceh | `/sejarah-singkat` | `Sejarah BSPJI Banda Aceh | Profil Lembaga` | Menjelaskan identitas dan sejarah lembaga |
| visi misi bspji aceh | `/visi-misi` | `Visi dan Misi BSPJI Banda Aceh` | Menjawab intent profil organisasi |
| tugas fungsi bspji aceh | `/tugas-fungsi` | `Tugas dan Fungsi BSPJI Banda Aceh` | Menjelaskan mandat lembaga |
| struktur organisasi bspji aceh | `/struktur-organisasi` | `Struktur Organisasi BSPJI Banda Aceh` | Menampilkan struktur yang aktual |
| pejabat bspji banda aceh | `/profil-pejabat` | `Profil Pejabat BSPJI Banda Aceh` | Menampilkan pimpinan dan pejabat |
| laboratorium pengujian aceh, pengujian bspji aceh | `/pengujian` | `Laboratorium Pengujian BSPJI Banda Aceh | Layanan dan Tarif` | Menjelaskan ruang lingkup, proses, tarif, dan CTA |
| kalibrasi aceh, kalibrasi bspji | `/kalibrasi` | `Layanan Kalibrasi BSPJI Banda Aceh | Ruang Lingkup dan Tarif` | Menjawab kebutuhan kalibrasi industri |
| sertifikasi produk sni aceh | `/sertifikasi-produk` | `Sertifikasi Produk SNI BSPJI Banda Aceh | Layanan LSPro` | Menjelaskan sertifikasi dan direktori pelanggan |
| lembaga pemeriksa halal aceh | `/lembaga-pemeriksa-halal` | `Lembaga Pemeriksa Halal BSPJI Banda Aceh` | Menjelaskan pemeriksaan halal dan prosesnya |
| sertifikasi industri hijau aceh | `/lsih` | `Lembaga Sertifikasi Industri Hijau BSPJI Banda Aceh` | Menjelaskan layanan LSIH |
| verifikasi tkdn aceh | `/verifikasi-tkdn` | `Verifikasi TKDN BSPJI Banda Aceh | Proses dan Persyaratan` | Menjelaskan alur dan ruang lingkup TKDN |
| pelatihan teknis industri aceh | `/pelatihan-teknis` | `Pelatihan Teknis Industri BSPJI Banda Aceh` | Menampilkan topik, peserta, dan proses pendaftaran |
| konsultasi industri aceh | `/konsultasi-pendampingan` | `Konsultansi dan Pendampingan Industri BSPJI Banda Aceh` | Menjelaskan jenis pendampingan dan CTA |
| ppid bspji aceh, informasi publik bspji | `/ppid` dan `/informasi-publik` | `PPID BSPJI Banda Aceh` / `Informasi Publik BSPJI Banda Aceh` | Menjawab kebutuhan dokumen dan transparansi |
| alamat bspji banda aceh, kontak bspji aceh | `/hubungi-kami` | `Kontak dan Lokasi BSPJI Banda Aceh` | Menguatkan sinyal lokasi dan konversi |

### Pola meta description

Gunakan ringkasan spesifik sekitar 140–160 karakter bila memungkinkan, tanpa memaksakan panjang. Contoh:

- Homepage: `Situs resmi BSPJI Banda Aceh untuk layanan pengujian, kalibrasi, sertifikasi produk, TKDN, pemeriksaan halal, pelatihan, dan konsultansi industri.`
- Pengujian: `Temukan ruang lingkup, alur, tarif, dan layanan laboratorium pengujian BSPJI Banda Aceh untuk kebutuhan industri dan standardisasi.`
- Kalibrasi: `Informasi layanan kalibrasi BSPJI Banda Aceh, meliputi ruang lingkup, alur pelayanan, tarif, sertifikat, dan standar pelayanan.`
- Sertifikasi produk: `Pelajari layanan sertifikasi produk SNI BSPJI Banda Aceh, persyaratan, alur, tarif, ruang lingkup, dan direktori pelanggan.`
- Kontak: `Alamat, telepon, email, peta, dan kanal konsultasi resmi BSPJI Banda Aceh untuk kebutuhan layanan standardisasi dan jasa industri.`
- Berita: gunakan excerpt berita yang benar-benar merangkum artikel, bukan description situs umum.

## 9. Rancangan Teknis yang Direkomendasikan

### 9.1 Konfigurasi SEO terpusat

Buat `config/seo.php` yang mengambil nilai environment hanya di file config dan menyimpan:

- nama situs;
- canonical base URL;
- default description;
- default share image;
- locale `id_ID`;
- data organisasi yang sudah diverifikasi;
- akun sosial resmi.

Layout Blade menggunakan nilai config dan menerima override per halaman. Escape seluruh nilai HTML; render JSON-LD menggunakan encoding JSON yang aman, bukan menyusun JSON dengan string manual.

### 9.2 Interface metadata layout

Komponen `x-layouts.app` direkomendasikan menerima:

| Properti | Fungsi | Default |
|---|---|---|
| `title` | Judul halaman | Nama situs |
| `description` | Ringkasan unik | Description situs |
| `canonical` | URL canonical final | URL route pada origin tepercaya |
| `robots` | Kebijakan indeks | `index,follow` |
| `ogType` | Tipe Open Graph | `website` |
| `ogImage` | Gambar sosial absolut | Gambar default 1200×630 |
| `structuredData` | Satu/lebih graph JSON-LD | Kosong |

### 9.3 Rancangan sitemap

- route: `GET /sitemap.xml`;
- route name: `sitemap`;
- controller/action: khusus untuk sitemap, tidak mencampur logic pada closure homepage;
- view XML atau response XML khusus;
- query berita: memakai scope `published()`, memilih kolom yang diperlukan saja, dan mengambil data secara terurut;
- cache: satu jam dengan invalidasi saat publikasi berita berubah;
- header: `Content-Type: application/xml; charset=UTF-8`.

### 9.4 Kebijakan URL

- origin canonical: HTTPS non-www;
- trailing slash: gunakan kebijakan saat ini, yaitu tanpa trailing slash kecuali root;
- tracking parameter: tidak masuk canonical;
- pagination: self-canonical;
- filter/search internal: `noindex,follow` dan canonical menuju halaman dasar;
- perubahan slug terpublikasi: redirect permanen ke slug terbaru;
- URL yang dihapus tanpa pengganti: `410 Gone` bila penghapusan memang permanen, selain itu `404` normal.

## 10. Roadmap Implementasi

### Fase 1 — Fondasi crawl dan canonical, 1–2 hari

1. Perbaiki sertifikat www dan redirect semua origin alternatif.
2. Set `APP_URL` dan locale produksi.
3. Perbaiki title yang masih menyebut Pekanbaru.
4. Implementasikan sitemap dinamis dan perbarui `robots.txt`.
5. Tambahkan pengujian sitemap, canonical, locale, dan identitas.

### Fase 2 — Metadata dan struktur entitas, 3–5 hari

1. Buat konfigurasi serta interface metadata layout.
2. Tulis title dan description unik untuk seluruh halaman tujuan.
3. Pisahkan server-render lima halaman profil.
4. Perbaiki canonical pagination dan query filter.
5. Tambahkan OG, Twitter Card, favicon, Organization/WebSite, BreadcrumbList, dan NewsArticle.
6. Samakan data kontak setelah email resmi dikonfirmasi.

### Fase 3 — Konten dan performa, 1–2 minggu

1. Audit copy setiap halaman layanan terhadap intent pencarian.
2. Perbaiki internal linking dan CTA.
3. Optimalkan video hero, code splitting, font, gambar responsif, alt, dan dimensi.
4. Implementasikan kebijakan slug berita dan indexability PDF.
5. Jalankan Lighthouse/PageSpeed pada homepage, satu halaman layanan, daftar berita, dan detail berita.

### Fase 4 — Search Console dan monitoring, 8–12 minggu

1. Verifikasi Domain Property melalui DNS.
2. Kirim `/sitemap.xml`.
3. Gunakan URL Inspection untuk homepage, halaman layanan prioritas, daftar berita, dan satu detail berita.
4. Minta indexing setelah perbaikan P0–P1 tayang.
5. Pantau Page Indexing, Core Web Vitals, HTTPS, structured data, crawl stats, dan manual actions.
6. Pantau query merek dan layanan mingguan selama empat minggu pertama, lalu bulanan.
7. Evaluasi impression, click, CTR, posisi, halaman tujuan, dan conversion action seperti klik telepon/form.

## 11. Matriks Pengujian

### 11.1 Feature test Laravel

| Skenario | Hasil yang diharapkan |
|---|---|
| Semua route publik utama | `200 OK` |
| Route tidak valid dan draft/future news | `404 Not Found` |
| Setiap halaman tujuan | Tepat satu title, description, canonical, dan H1 |
| Metadata halaman layanan | Unik dan memuat identitas BSPJI Banda Aceh secara alami |
| Lima halaman profil | Title, description, H1, canonical, dan konten utama berbeda |
| `/berita?page=2` | Self-canonical mempertahankan `page=2` |
| `/sertifikasi-produk?direktori_page=2` | Self-canonical mempertahankan `direktori_page=2` |
| Query tracking | Dihapus dari canonical |
| Query pencarian internal | `noindex,follow` dan canonical ke URL dasar |
| Homepage | Organization/WebSite JSON-LD valid secara sintaksis |
| Detail berita | NewsArticle memakai data berita dan cover yang benar |
| `/sitemap.xml` | `200`, content type XML, dan XML dapat diparse |
| Sitemap static URL | Hanya origin HTTPS non-www |
| Sitemap berita | Hanya published news; draft dan future news tidak ada |
| Sitemap private routes | Admin, API, health, pengaduan, dan download tidak ada |
| `robots.txt` | `200` dan menunjuk sitemap canonical |

Gunakan data provider untuk matriks halaman publik agar test metadata tidak diduplikasi. Untuk test yang memerlukan database, ikuti pola proyek dan pertimbangkan `LazilyRefreshDatabase` agar suite SEO tidak menambah waktu migrasi secara berlebihan.

### 11.2 Verifikasi server dan manual

1. Jalankan `curl -I` pada HTTP/HTTPS dan www/non-www; pastikan hanya origin canonical yang `200`.
2. Uji sertifikat untuk kedua hostname.
3. Validasi sitemap dengan XML parser dan Search Console.
4. Buka halaman dengan JavaScript dimatikan untuk memastikan konten, link, title, description, canonical, dan H1 tetap tersedia.
5. Validasi JSON-LD dengan Rich Results Test dan Schema Markup Validator.
6. Jalankan PageSpeed Insights mobile dan desktop.
7. Uji favicon dan preview sosial.
8. Gunakan URL Inspection “Test live URL” untuk memastikan Googlebot menerima HTML yang sama dan resource penting tidak diblokir.

### 11.3 Baseline proyek

Pada audit read-only, 34 targeted feature tests untuk berita dan halaman layanan lulus dengan 117 assertion. Baseline ini menunjukkan fungsi utama yang diuji masih berjalan, tetapi belum membuktikan kesiapan SEO karena belum ada test khusus metadata, sitemap, canonical, schema, atau redirect server.

Setelah implementasi sitemap dan koreksi title, suite terarah untuk sitemap, sertifikasi produk, konsultansi/pendampingan, dan berita menghasilkan **18 test lulus dengan 232 assertion**. Test baru memverifikasi XML valid, content type, URL HTTPS non-www, pengecualian URL nonpublik/query, scope berita published, `lastmod`, serta invalidasi cache ketika visibilitas berita berubah.

Seluruh feature suite juga lulus dengan **140 test dan 1.000 assertion**. Perintah `php artisan test` tanpa path belum dapat dijadikan satu-satunya perintah CI karena `phpunit.xml` merujuk direktori `tests/Unit` yang belum tersedia; verifikasi lengkap saat ini dijalankan melalui `php artisan test tests/Feature`. Kondisi direktori Unit tersebut sudah ada sebelum perubahan sitemap dan tidak berasal dari implementasi SEO.

## 12. Kriteria Penerimaan Akhir

Optimasi fondasi SEO dianggap selesai ketika:

- semua origin alternatif redirect permanen satu langkah ke HTTPS non-www;
- sertifikat valid untuk host utama dan www;
- sitemap memberikan `200`, valid, terkirim di Search Console, dan hanya memuat URL canonical yang layak diindeks;
- produksi menggunakan `lang="id"`;
- tidak ada referensi publik “BSPJI Pekanbaru”;
- seluruh halaman prioritas memiliki title, description, H1, canonical, dan metadata sosial yang relevan;
- lima halaman profil memiliki konten utama yang berbeda;
- pagination memiliki self-canonical dan parameter tracking tidak membuat canonical baru;
- Organization/WebSite, BreadcrumbList, dan NewsArticle valid;
- favicon valid dan tidak kosong;
- data alamat, telepon, dan email konsisten;
- tidak ada draft, private route, hasil pencarian internal, atau endpoint utilitas di sitemap;
- halaman prioritas mencapai target LCP ≤2,5 detik, INP <200 ms, dan CLS <0,1 pada data lapangan;
- Search Console tidak melaporkan error server, redirect, canonical, atau structured data yang belum ditangani.

## 13. Checklist Google Search Console

- [ ] Verifikasi Domain Property `bspjiaceh.kemenperin.go.id` melalui DNS.
- [ ] Pastikan versi HTTPS non-www diperlakukan sebagai origin canonical.
- [ ] Kirim `https://bspjiaceh.kemenperin.go.id/sitemap.xml`.
- [ ] Periksa homepage melalui URL Inspection.
- [ ] Periksa `/pengujian`, `/kalibrasi`, `/sertifikasi-produk`, `/lembaga-pemeriksa-halal`, dan `/verifikasi-tkdn`.
- [ ] Periksa `/berita` dan satu detail berita terbaru.
- [ ] Pastikan “User-declared canonical” sama dengan “Google-selected canonical”.
- [ ] Periksa Page Indexing dan alasan URL tidak diindeks.
- [ ] Periksa laporan Core Web Vitals mobile dan desktop.
- [ ] Periksa HTTPS, structured data, manual actions, dan security issues.
- [ ] Pantau query `bspji banda aceh`, `bspji aceh`, serta variasi layanan.
- [ ] Catat baseline impression, click, CTR, dan posisi sebelum dan sesudah implementasi.

## 14. Referensi Resmi

- [Google Search Central — Build and submit a sitemap](https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap)
- [Google Search Central — Canonical URLs](https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls)
- [Google Search Central — Title links](https://developers.google.com/search/docs/appearance/title-link)
- [Google Search Central — Meta descriptions and snippets](https://developers.google.com/search/docs/appearance/snippet)
- [Google Search Central — Organization structured data](https://developers.google.com/search/docs/appearance/structured-data/organization)
- [Google Search Central — Breadcrumb structured data](https://developers.google.com/search/docs/appearance/structured-data/breadcrumb)
- [Google Search Central — Structured data guidelines](https://developers.google.com/search/docs/appearance/structured-data/sd-policies)
- [Google Search Central — Block indexing with noindex](https://developers.google.com/search/docs/crawling-indexing/block-indexing)
- [Google Search Central — Core Web Vitals](https://developers.google.com/search/docs/appearance/core-web-vitals)
- [Google Search Central — Technical SEO guidance](https://developers.google.com/search/docs/fundamentals/get-started)

## 15. Urutan Tindakan yang Disarankan

Jika hanya dapat mengerjakan sedikit perubahan, lakukan dalam urutan berikut:

1. perbaiki TLS dan redirect HTTP/www;
2. hadirkan sitemap yang valid;
3. perbaiki locale dan title “Pekanbaru”;
4. buat metadata unik dan perbaiki halaman profil duplikat;
5. perbaiki canonical pagination;
6. tambahkan structured data, metadata sosial, dan favicon;
7. optimalkan performa dan konten layanan;
8. verifikasi serta monitor melalui Search Console.

Melaksanakan urutan tersebut akan memperbaiki fondasi teknis terlebih dahulu, kemudian relevansi kata kunci, tampilan hasil pencarian, pengalaman pengguna, dan proses monitoring berkelanjutan.
