# Detail Informasi Publik

Fitur ini menambahkan **4 halaman detail informasi** yang dapat diakses dari tab "Daftar Informasi" di halaman Informasi Publik. Setiap halaman menampilkan dokumen PDF yang dapat diunduh, dikelompokkan berdasarkan kategori.

## Konteks Saat Ini

- Halaman **Informasi Publik** ([informasi-publik.blade.php](file:///c:/laragon/www/bspji-1/resources/views/informasi-publik.blade.php)) sudah ada dengan 2 tab: "Daftar Informasi" dan "Permohonan Informasi"
- Cluster **InformasiPublik** ([InformasiPublikCluster.php](file:///c:/laragon/www/bspji-1/app/Filament/Clusters/InformasiPublik/InformasiPublikCluster.php)) sudah ada di navigation group "Informasi"
- Tab "Daftar Informasi" saat ini menampilkan 1 PDF saja — PDF tersebut akan dipertahankan dan di atasnya akan ditambah menu 4 kategori dengan tombol "Lihat"

---

## Arsitektur Database

### Model: `DetailInformasi`

Satu model/tabel universal untuk menyimpan dokumen dari 2 jenis informasi aktif (Berkala & Setiap Saat). Dibedakan oleh kolom `tipe` dan `kategori_id`.

#### [NEW] Migration: `create_detail_informasis_table`

```php
Schema::create('detail_informasis', function (Blueprint $table) {
    $table->id();
    $table->string('tipe');           // 'berkala', 'setiap_saat'
    $table->string('kategori_id');    // ID kategori unik (e.g. 'dipa', 'rka_kl', 'renstra')
    $table->string('judul');          // Judul/nama dokumen
    $table->string('pdf_file');       // Path file PDF
    $table->text('keterangan')->nullable(); // Keterangan opsional
    $table->integer('urutan')->default(0);   // Urutan tampil
    $table->timestamps();
});
```

> [!IMPORTANT]
> Pendekatan **1 tabel** dipilih agar lebih sederhana dan mudah di-maintain. Kolom `tipe` membedakan jenis informasi, dan `kategori_id` membedakan sub-kategori.

---

## Daftar Kategori per Tipe Informasi

### 1. Informasi Berkala (`tipe = 'berkala'`)

| No | `kategori_id` | Label Tampil |
|----|---------------|-------------|
| 1 | `profil` | Profil |
| 2 | `dipa` | DIPA |
| 3 | `rka_kl` | RKA-K/L |
| 4 | `renstra` | Renstra |
| 5 | `kak` | KAK |
| 6 | `laporan_akuntabilitas` | Laporan Akuntabilitas |
| 7 | `renkin` | Renkin |
| 8 | `anggaran_program_kegiatan` | Anggaran Program dan Kegiatan |
| 9 | `ringkasan_informasi` | Ringkasan Informasi Program dan Kegiatan |
| 10 | `perjanjian_kinerja` | Perjanjian Kinerja |
| 11 | `laporan_keuangan` | Laporan Keuangan |
| 12 | `laporan_bmn` | Laporan BMN |
| 13 | `laporan_informasi_publik` | Laporan Informasi Publik |
| 14 | `laporan_pp39` | Laporan PP 39 |
| 15 | `laporan_pengadaan` | Laporan Pengadaan Barang dan Jasa |
| 16 | `lhkpn` | LHKPN |
| 17 | `dasar_hukum_tarif` | Dasar Hukum Tarif Layanan |
| 18 | `laporan_kepegawaian` | Laporan Kepegawaian |
| 19 | `data_kepegawaian` | Data Kepegawaian |
| 20 | `peraturan` | Peraturan |

---

### 2. Informasi Setiap Saat (`tipe = 'setiap_saat'`)

| No | `kategori_id` | Label Tampil |
|----|---------------|-------------|
| 1 | `data_statistik` | Data Statistik |
| 2 | `prosedur_peringatan_dini` | Prosedur Peringatan Dini dan Evakuasi Keadaan Darurat |
| 3 | `laporan_kepuasan_pelanggan` | Laporan Kepuasan Pelanggan |
| 4 | `rekapitulasi_keluhan` | Rekapitulasi Keluhan Pelanggan |

---

### 3. Informasi Serta Merta & 4. Informasi Dikecualikan

> Tidak memerlukan admin panel maupun database. Frontend menampilkan halaman statis dengan pesan **"Tidak ada data"**.

---

## Admin Panel — Filament Resource

### Pendekatan: 1 Resource Saja

> [!TIP]
> Menggunakan **1 resource** (`DetailInformasiResource`) lebih optimal daripada 2 resource terpisah karena:
> - Model dan tabel yang sama → tidak perlu duplikasi form/table logic
> - Lebih sedikit file yang di-maintain (1 set Form + Table vs 2 set)
> - Performa identik — query yang sama dijalankan
> - Admin cukup pilih `tipe` (Berkala/Setiap Saat) di form, lalu pilih kategori yang sesuai
> - Tabel bisa difilter/di-group berdasarkan `tipe` menggunakan Filament Tabs

### Penempatan di Cluster yang Sudah Ada

Resource baru akan ditambahkan ke dalam cluster **InformasiPublik** yang sudah ada (navigation group "Informasi"), sehingga muncul berdampingan dengan "Daftar Informasi Publik" dan "Permohonan Informasi" di sub-navigasi atas.

#### [NEW] Resource: `DetailInformasiResource`
- Path: `app/Filament/Clusters/InformasiPublik/Resources/DetailInformasis/`
- Cluster: `InformasiPublikCluster`
- Navigation Label: `Detail Informasi`
- Icon: `Heroicon::OutlinedFolderOpen`

**Form berisi:**
- **Select Tipe**: Berkala / Setiap Saat (wajib, live — mengubah opsi kategori)
- **Select Kategori**: Opsi dinamis berdasarkan tipe yang dipilih (wajib)
- **Judul**: Nama dokumen (wajib)
- **Upload PDF**: File PDF (wajib)
- **Keterangan**: Textarea opsional
- **Urutan**: Number input untuk menentukan urutan tampil

**Tabel berisi:**
- **Tipe**: Badge (Berkala = hijau, Setiap Saat = biru)
- **Kategori**: Label kategori
- **Judul**: Nama dokumen
- **Tanggal Upload**: `created_at`
- **Tabs filter**: Tab "Semua", "Informasi Berkala", "Informasi Setiap Saat" di atas tabel

> [!NOTE]
> Kolom `kategori_id` pada form akan menampilkan opsi yang berbeda tergantung tipe yang dipilih. Jika admin memilih "Berkala", maka muncul 20 kategori. Jika "Setiap Saat", muncul 4 kategori.

---

## Frontend — Perubahan Halaman

### 1. Modifikasi Tab "Daftar Informasi" di [informasi-publik.blade.php](file:///c:/laragon/www/bspji-1/resources/views/informasi-publik.blade.php)

Di atas PDF yang sudah ada, akan ditambahkan **daftar menu** dengan 4 baris:

```
┌──────────────────────────────────────────────────────┐
│  📋  Informasi Berkala                    [ Lihat → ] │
│  🕐  Informasi Setiap Saat               [ Lihat → ] │
│  ⚡  Informasi Serta Merta               [ Lihat → ] │
│  🔒  Informasi Dikecualikan              [ Lihat → ] │
└──────────────────────────────────────────────────────┘

─── PDF Daftar Informasi Publik (yang sudah ada) ───
```

Tombol "Lihat" akan mengarahkan ke halaman detail masing-masing.

### 2. Halaman Detail Informasi

#### [NEW] Blade: `resources/views/detail-informasi.blade.php`

Satu template yang digunakan untuk ke-4 halaman, dibedakan oleh parameter route.

**Fitur halaman:**
- **Navigasi atas**: Panah kiri/kanan untuk berpindah antar jenis informasi (Berkala → Setiap Saat → Serta Merta → Dikecualikan)
- **Untuk Berkala & Setiap Saat**: Dokumen dikelompokkan berdasarkan `kategori_id` dengan header kategori, setiap dokumen PDF memiliki tombol download
- **Untuk Serta Merta & Dikecualikan**: Tampil halaman statis dengan pesan "Tidak ada data" yang di-style secara premium (empty state)

```
                    ← Informasi Berkala →
    
    ┌─ DIPA ──────────────────────────────────────────┐
    │  📄 DIPA 2024.pdf                    [Download]  │
    │  📄 DIPA 2025.pdf                    [Download]  │
    └──────────────────────────────────────────────────┘
    
    ┌─ RKA-K/L ───────────────────────────────────────┐
    │  📄 RKA-KL Revisi 2024.pdf           [Download]  │
    └──────────────────────────────────────────────────┘
```

```
                  ← Informasi Serta Merta →

    ┌──────────────────────────────────────────────────┐
    │                                                  │
    │          🚫  Tidak ada data tersedia              │
    │    Informasi serta merta belum tersedia          │
    │    saat ini.                                     │
    │                                                  │
    └──────────────────────────────────────────────────┘
```

### 3. Routes Baru

```php
Route::get('/informasi-publik/detail/{tipe}', [DetailInformasiController::class, 'show'])
    ->name('detail-informasi.show');
```

Parameter `{tipe}` berisi: `berkala`, `setiap_saat`, `serta_merta`, `dikecualikan`.

### 4. Controller Baru

#### [NEW] `DetailInformasiController`

Controller menangani 4 tipe. Untuk `serta_merta` dan `dikecualikan`, tidak query database — langsung return view dengan koleksi kosong.

```php
public function show(string $tipe): View
{
    $validTipes = ['berkala', 'setiap_saat', 'serta_merta', 'dikecualikan'];
    abort_unless(in_array($tipe, $validTipes), 404);

    // Untuk serta_merta dan dikecualikan, tidak ada data di DB
    $dokumen = in_array($tipe, ['berkala', 'setiap_saat'])
        ? DetailInformasi::where('tipe', $tipe)
            ->orderBy('kategori_id')
            ->orderBy('urutan')
            ->get()
            ->groupBy('kategori_id')
        : collect();

    return view('detail-informasi', compact('tipe', 'dokumen'));
}
```

---

## Ringkasan File yang Akan Dibuat/Dimodifikasi

### File Baru
| File | Deskripsi |
|------|-----------|
| `database/migrations/..._create_detail_informasis_table.php` | Migration tabel |
| `app/Models/DetailInformasi.php` | Model Eloquent |
| `app/Filament/Clusters/InformasiPublik/Resources/DetailInformasis/DetailInformasiResource.php` | 1 Resource Filament |
| `app/Filament/Clusters/InformasiPublik/Resources/DetailInformasis/Schemas/` | Form schema |
| `app/Filament/Clusters/InformasiPublik/Resources/DetailInformasis/Tables/` | Table definition |
| `app/Filament/Clusters/InformasiPublik/Resources/DetailInformasis/Pages/` | List, Create, Edit pages |
| `app/Http/Controllers/DetailInformasiController.php` | Controller frontend |
| `resources/views/detail-informasi.blade.php` | Halaman detail (shared untuk 4 tipe) |

### File Dimodifikasi
| File | Perubahan |
|------|-----------|
| `resources/views/informasi-publik.blade.php` | Tambah menu 4 kategori di atas PDF yang sudah ada |
| `routes/web.php` | Tambah route detail informasi |

---

## Verification Plan

### Automated Tests
- `php artisan test --compact --filter=DetailInformasi` — Tes CRUD resource
- Tes migrasi: `php artisan migrate`
- Run pint: `vendor/bin/pint --dirty --format agent`

### Manual Verification
- Verifikasi admin panel: resource "Detail Informasi" tampil di sub-navigasi cluster Informasi Publik
- Verifikasi form: pilih tipe → opsi kategori berubah sesuai tipe
- Verifikasi upload dokumen per kategori
- Verifikasi frontend: tab "Daftar Informasi" menampilkan menu 4 kategori + PDF yang sudah ada
- Verifikasi halaman detail Berkala & Setiap Saat menampilkan dokumen grouped by kategori
- Verifikasi halaman detail Serta Merta & Dikecualikan menampilkan "Tidak ada data"
- Verifikasi navigasi panah berpindah antar jenis informasi
- Verifikasi tombol download berfungsi
