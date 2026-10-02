# Dokumen Perencanaan: Penambahan Multi-Gambar Sertifikasi Layanan Pengujian

Dokumen ini memuat analisis, strategi arsitektur, dan langkah implementasi teknis untuk memungkinkan penambahan lebih dari satu gambar sertifikat akreditasi pada tab Sertifikasi Layanan Pengujian (Admin Panel Filament & Halaman Publik).

---

## 1. Latar Belakang & Analisis Masalah

### 1.1 Masalah Saat Ini
Pada Admin Panel Filament, khususnya Cluster **Layanan Pengujian** (`PengujianCluster`) di Resource **Sertifikasi** (`SertifikasiResource`), admin hanya dapat mengelola 1 gambar. Tombol untuk menambah data baru (*Create/Tambah*) tidak tersedia.

### 1.2 Temuan Teknis (Root Cause)
1. **`SertifikasiResource.php`**: Method `canCreate()` di-override dan mengembalikan `false`, sehingga Filament menonaktifkan pembuatan data baru.
2. **`ListSertifikasis.php`**: Method `getHeaderActions()` mengembalikan array kosong (`[]`), sehingga tombol aksi `CreateAction` tidak dirender pada header tabel daftar sertifikasi.
3. **`PengujianController.php`**: Query pengambilan data ke database menggunakan `Sertifikasi::first()`, yang hanya mengambil satu entitas record pertama.
4. **`pengujian.blade.php`**: Komponen tampilan publik mengasumsikan data `$sertifikasi` adalah single record dan hanya menampilkan 1 gambar sertifikat beserta tombol unduhnya.

---

## 2. Pemilihan Solusi & Arsitektur

### Pola yang Dianut: Multi-Record Pattern (Consistency First)
Pendekatan ini menyamakan arsitektur yang sudah berjalan baik pada layanan sejenis di aplikasi ini, yaitu:
- **Layanan Kalibrasi** (`SertifikasiKalibrasiResource` & `kalibrasi.blade.php`)
- **Layanan Sertifikasi Produk** (`SertifikatProdukResource` & `sertifikasi-produk.blade.php`)

### Keunggulan:
1. **Konsistensi Codebase**: Sesuai dengan prinsip *Laravel Best Practices: Consistency First*.
2. **Tanpa Migrasi Database**: Tabel `sertifikasis` sudah memiliki skema `id`, `image`, `created_at`, `updated_at` yang langsung mendukung multi-record.
3. **Manajemen Granular**: Setiap sertifikat dapat diunggah, diperbarui (*edit*), atau dihapus (*delete*) secara independen oleh administrator.
4. **Batas Fleksibel**: Dapat diberi batas wajar (misalnya hingga 4 gambar seperti Kalibrasi, atau disesuaikan) untuk menjaga performa tata letak.

---

## 3. Rincian File yang Dimodifikasi

| No | File | Deskripsi Perubahan |
|----|------|---------------------|
| 1 | `app/Filament/Clusters/Pengujian/Resources/SertifikasiResource/Pages/ListSertifikasis.php` | Menambahkan `CreateAction::make()` ke `getHeaderActions()`. |
| 2 | `app/Filament/Clusters/Pengujian/Resources/SertifikasiResource.php` | Mengubah method `canCreate()` agar mengizinkan penambahan record baru (misal: `Sertifikasi::count() < 4`). |
| 3 | `app/Http/Controllers/PengujianController.php` | Mengubah query dari `Sertifikasi::first()` menjadi `$sertifikasis = Sertifikasi::latest()->get()`, dan mengirimkan variabel `$sertifikasis` ke view. |
| 4 | `resources/views/pengujian.blade.php` | Mengubah section tab sertifikasi menjadi responsive grid layout yang me-loop `$sertifikasis`, lengkap dengan tombol download dan lightbox zoom untuk setiap sertifikat. |

---

## 4. Rencana Langkah Kerja Eksekusi

1. **Membuat Dokumen Perencanaan**: Menyimpan file `perencanaanserpeng.md` sebagai acuan eksekusi.
2. **Modifikasi Admin Panel (Filament)**:
   - Tambahkan `CreateAction` di `ListSertifikasis.php`.
   - Update `canCreate()` di `SertifikasiResource.php`.
3. **Modifikasi Backend Controller**:
   - Ambil seluruh data sertifikasi dengan `Sertifikasi::latest()->get()`.
   - Teruskan variabel `$sertifikasis` ke view `pengujian`.
4. **Modifikasi Frontend Blade View**:
   - Terapkan loop `@foreach($sertifikasis as $sert)` dalam grid responsif (1 kolom di mobile, 2 kolom di tablet/desktop).
   - Sediakan tombol Download dan fitur Lightbox zoom interaktif untuk masing-masing gambar sertifikat.
5. **Verifikasi & Validasi**:
   - Lakukan linting dan pengecekan sintaks PHP via CLI.
   - Pastikan rute dan render blade berjalan tanpa exception.
