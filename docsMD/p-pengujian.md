# P-Pengujian — Alur Program: Menu Pelayanan Pengujian (Filament Backend)

Dokumen ini memetakan seluruh file yang terlibat dalam menu **Pengujian** pada panel admin Filament, peran masing-masing file, serta alur keterkaitan antar file (dari klik menu di sidebar sampai data tampil di halaman publik `/pengujian`).

> Lingkungan: Laravel 13 + Filament 5. Proyek `c:\laragon\www\bspji-1`.

---

## 1. Posisi Menu dalam Panel

```
Admin Panel (/admin)
└── Navigation Group: "Pelayanan"
    └── Cluster: Pengujian  (PengujianCluster)
        ├── Submenu: Sertifikasi      → SertifikasiResource
        ├── Submenu: Ruang Lingkup    → RuangLingkupResource
        ├── Submenu: Alur Pengujian   → AlurPengujianResource
        ├── Submenu: SPM              → SpmPengujianResource
        └── Submenu: Tarif Pengujian  → KomoditiResource
```

Karena cluster memakai `SubNavigationPosition::Top`, semua submenu ini muncul sebagai tab horizontal di atas halaman (bukan dropdown sidebar).

---

## 2. Peta File (Ringkas)

| # | File | Peran Utama |
|---|------|-------------|
| 1 | `app/Filament/Clusters/Pengujian/PengujianCluster.php` | Mendefinisikan grup navigasi menu |
| 2 | `app/Filament/Clusters/Pengujian/Resources/AlurPengujianResource.php` | Resource "Alur Pengujian" (1 gambar) |
| 3 | `.../AlurPengujianResource/Pages/{List,Create,Edit}*.php` | Halaman CRUD alur pengujian |
| 4 | `app/Filament/Clusters/Pengujian/Resources/SertifikasiResource.php` | Resource "Sertifikasi" (gambar akreditasi) |
| 5 | `.../SertifikasiResource/Pages/{List,Create,Edit}*.php` | Halaman CRUD sertifikasi |
| 6 | `app/Filament/Clusters/Pengujian/Resources/RuangLingkupResource.php` | Resource "Ruang Lingkup" (tabel teks per lab) |
| 7 | `.../RuangLingkupResource/Pages/{List,Create,Edit}*.php` | Halaman CRUD ruang lingkup |
| 8 | `app/Filament/Clusters/Pengujian/Resources/KomoditiResource.php` | Resource "Tarif Pengujian" (komoditi → parameter) |
| 9 | `.../KomoditiResource/Pages/{List,Create,Edit}*.php` | Halaman CRUD komoditi |
| 10 | `.../KomoditiResource/RelationManagers/ParameterRelationManager.php` | Kelola parameter + harga di dalam halaman komoditi |
| 11 | `app/Filament/Clusters/Pengujian/Resources/SpmPengujianResource.php` | Resource "SPM" (1 gambar webp) |
| 12 | `.../SpmPengujianResource/Pages/{List,Create,Edit}*.php` | Halaman CRUD SPM |
| 13 | `app/Models/{AlurPengujian,Sertifikasi,RuangLingkup,Komoditi,Parameter,Lab,SpmPengujian}.php` | Model Eloquent + relasi |
| 14 | `app/Policies/SpmPengujianPolicy.php` | Otorisasi khusus SPM (admin-only) |
| 15 | `app/Actions/Images/ConvertUploadedImageToWebp.php` | Konversi aman gambar → WebP |
| 16 | `app/Exceptions/InvalidUploadedImage.php` | Pengecualian khusus gagal-konversi |
| 17 | `app/Rules/AuthorizedSpmImageUpload.php` | Validasi ulang path gambar SPM |
| 18 | `database/migrations/*` (10 file) | Struktur tabel |
| 19 | `database/seeders/LabSeeder.php` | Seed 5 lab tetap |
| 20 | `app/Providers/Filament/AdminPanelProvider.php` | Registrasi panel + auto-discover cluster/resource |
| 21 | `app/Console/Commands/ImportParameters.php` | (alat bantu) Import data parameter legacy via CSV |
| 22 | `app/Models/User.php` (metode `isAdmin()`) | Basis aturan otorisasi |

**Rantai konsumen frontend (di luar Filament, melengkapi alur):**
`app/Http/Controllers/PengujianController.php` → `resources/views/pengujian.blade.php` + `app/Livewire/TarifPengujian.php` → `resources/views/livewire/tarif-pengujian.blade.php` → route `GET /pengujian` di `routes/web.php`.

---

## 3. Lapisan Database (Migrasi)

Urutan migrasi mencerminkan evolusi fitur. Tabel-tabel menu Pengujian:

| Tabel | Migrasi | Kolom penting |
|-------|---------|---------------|
| `sertifikasis` | `2026_04_05_131307` | `image` (string, satu baris) |
| `ruang_lingkups` | `2026_04_05_131308` + `2026_05_02_090000` (menambah kolom `lab`) | `lab`, `komoditi`, `ruang_lingkup` |
| `alur_pengujians` | `2026_04_07_035310` | `image` (satu baris) |
| `labs` | `2026_05_02_100000` | `nama` — 5 lab tetap (di-seed `LabSeeder`) |
| `komoditis` | `2026_05_02_100100` | `nama`, `peraturan`, `lab_id` (FK→labs), `keterangan` |
| `parameters` | `2026_05_02_100200` + 2 migrasi harga | `nama`, `metode_uji`, `satuan`, `baku_mutu`, `lab_id`, `komoditi_id` (FK cascade delete), `harga`. **Catatan nullability:** migrasi awal membuat `harga` sebagai `unsignedInteger()->default(0)` (non-nullable); dua migrasi susulan `2026_05_03_181203` (ubah jadi `nullable()->default(null)`) dan `2026_05_03_184629` (konversi nilai `0` existing → `null`) yang membuatnya nullable integer Rupiah seperti state akhir sekarang. |
| `spm_pengujians` | `2026_07_28_000000` | `image_path` (string, satu baris) |

**Relasi:**
```
Lab 1 ─── N Komoditi 1 ─── N Parameter
        └────────── N Parameter (lagi, via lab_id)
```
- `komoditis.lab_id` `cascadeOnDelete` → menghapus lab menghapus komoditinya.
- `parameters.komoditi_id` & `parameters.lab_id` `cascadeOnDelete`.
- Index komposit `['komoditi_id', 'lab_id']` untuk akses cepat parameter per komoditi.

---

## 4. Peran File per Lapisan

### 4.1 Registrasi Panel — `app/Providers/Filament/AdminPanelProvider.php`
- Membangun panel id `admin` di path `/admin`, dengan login, mode SPA, warna primer `Amber`, plus `renderHook(HEAD_END)` yang menyuntik CSS sidebar.
- Baris penting:
  - `discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')` → memindai `app/Filament/Resources` (resource **top-level** di luar cluster), **bukan** folder cluster.
  - `discoverClusters(in: app_path('Filament/Clusters'), for: 'App\Filament\Clusters')` → memindai `app/Filament/Clusters`.
  - Selain itu juga `discoverPages`, `discoverWidgets`, dan mendaftar `Dashboard` + widget default.
- **Mekanisme penemuan resource Pengujian** (penting, sering disalahpahami):
  - Resource Pengujian berada di `app/Filament/Clusters/Pengujian/Resources/`. Ia **tidak** ditemukan oleh `discoverResources` (yang hanya memindai folder top-level), melainkan ditemukan **oleh Cluster itu sendiri**: `Cluster` base class Filament melakukan discovery resource di subdirektori `Resources/` miliknya.
  - Rantai sebenarnya: `discoverClusters` → `PengujianCluster` terdaftar di panel → cluster menemukan resource di `Clusters/Pengujian/Resources/` sendiri.
- Karena auto-discovery, **tidak ada registrasi manual**. Menambahkan file `*Cluster.php` (atau `*Resource.php` di dalam subdirektori `Resources/` suatu cluster) otomatis terdeteksi (setelah `php artisan filament:cache-components` / clear cache bila komponen di-cache).

### 4.2 Cluster — `PengujianCluster.php`
- `namespace App\Filament\Clusters\Pengujian` → namespace ini juga menjadi basis auto-discovery resource cluster.
- `$navigationGroup = 'Pelayanan'` → muncul di grup sidebar "Pelayanan".
- `$navigationIcon = Heroicon::OutlinedSquares2x2`, `$navigationLabel = 'Pengujian'`.
- `$subNavigationPosition = SubNavigationPosition::Top` → submenu resource dirender sebagai tab di atas, bukan navigasi sidebar.

### 4.3 Resource sederhana "gambar tunggal" — `AlurPengujianResource` & `SertifikasiResource`
Pola kedua resource ini identik dan sederhana:
- `$model` → Model target.
- `$cluster` → mengaitkan ke `PengujianCluster` (inilah yang membuatnya jadi submenu Pengujian).
- `form()` → satu `FileUpload` `image`, disk `public`, direktori `alur_pengujian` / `sertifikasi`, wajib diisi.
- `table()` → `ImageColumn` persegi + aksi Edit/Delete, tanpa paginasi (`paginated(false)` karena memang 1 record target). Kedua tabel juga punya kolom `created_at` (dateTime, sortable) yang **tersembunyi secara default** (`toggleable(isToggledHiddenByDefault: true)`).
- Perbedaan:
  - **AlurPengujian**: `canCreate()` mengecek `AlurPengujian::count() < 1` — hanya boleh ada **1 record alur**.
  - **Sertifikasi**: `canCreate()` mengembalikan `false` selalu — record sertifikat dibuat via seeder/DB, admin hanya bisa edit/hapus. (Catatan: tabel Sertifikasi juga punya `created_at` tersembunyi seperti di atas.)

### 4.4 Resource "Ruang Lingkup" — `RuangLingkupResource`
- Form: `komoditi` (TextInput wajib) + `ruang_lingkup` (Textarea polos, **tidak disanitasi** — string apa pun disimpan mentah). Jika tabel punya kolom `lab`, tambahkan `Select` lab di urutan teratas (`array_unshift`).
- **⚠ Catatan keamanan (HTML mentah):** field `ruang_lingkup` sengaja diperbolehkan berisi HTML dan dirender **tanpa escape** di frontend via Alpine `x-html` (`pengujian.blade.php` → `ruang_lingkup_html`). Karena form Filament hanya memakai `Textarea` biasa (tanpa `->html()`/sanitizer), HTML berbahaya yang dimasukkan akan tampil mentah. Risiko terbatas karena hanya admin yang bisa mengelola, tetapi ini adalah **permukaan XSS** yang patut diwaspadai — jangan mengizinkan kontributor non-admin mengisi field ini tanpa sanitasi tambahan.
- **Pola adaptif kolom `lab`**: karena `ruang_lingkups` pernah dipakai tanpa kolom `lab` (migrasi `2026_05_02_090000` menambahkannya belakangan), resource mengecek `RuangLingkup::hasLabColumn()` (cache `Schema::hasColumn` lewat `??=`). Ini membuat form/table/filter beradaptasi: ada kolom lab → tampilkan Select lab, badge lab (`formatStateUsing getLabLabel`), filter `SelectFilter` lab, dan urutkan per lab; tidak ada → tampilkan hanya komoditi+ruang lingkup.
- `table()` memakai scope `orderedByLab()` dari model. Perilaku scope (lengkap):
  - **Jika kolom `lab` tidak ada** → hanya `orderBy('komoditi')` (alfabet per komoditi) — bukan urutan lab.
  - **Jika kolom `lab` ada** → `orderByRaw(CASE lab WHEN ... THEN 1..5 ELSE 99 END)` (urutan lab sesuai `LAB_OPTIONS`), **lalu secondary `orderBy('komoditi')`** (alfabet per komoditi dalam lab yang sama).
  - Tabel juga punya kolom `created_at` tersembunyi default (`toggleable(isToggledHiddenByDefault: true)`).
- `canCreate()` selalu `true`.

### 4.5 Resource "Tarif Pengujian" — `KomoditiResource`
Inti fitur tarif:
- Label navigasi **"Tarif Pengujian"** (`$navigationLabel`), sedangkan model label tetap "Komoditi".
- Form: `nama`, `lab_id` (Select relasi ke `lab`, urut abjad, pencarian + preload), `peraturan`, `keterangan`.
- Table: eager-load `lab`, `withCount('parameters')` → kolom "Jumlah Parameter", filter `SelectFilter` per lab. Kolom `created_at` (dateTime, sortable) tersembunyi default. Query diurutkan `orderBy('nama')`.
- **`getRelations()`** mendaftarkan `ParameterRelationManager::class` → halaman Edit komoditi punya tab "Parameter".

#### RelationManager — `ParameterRelationManager.php`
- `$relationship = 'parameters'` → relasi `Komoditi::parameters()`, bekerja di dalam konteks owner record (komoditi yang sedang diedit).
- Form parameter: `nama`, `lab_id` (default mengikuti `getOwnerRecord()->lab_id` → parameter baru otomatis lahir di lab komoditi induk; tetap bisa diganti), `metode_uji`, `satuan`, `baku_mutu`, `harga` (numeric prefix `Rp`, di-dehydrate: kosong/0 → `null`).
- Table: kolom `nama`, `metode_uji`, `satuan`, `baku_mutu`, `harga` (format `Number::currency(..., 'IDR', 'id')`; 0/null → "-"). Aksi create/edit/delete single + `DeleteBulkAction`.

### 4.6 Resource "SPM" — `SpmPengujianResource`
Resource dengan keamanan upload paling ketat:
- `$slug = 'spm'` (URL admin tetap `/spm`, namespace aman dari bentrok nama).
- `canCreate()` = `parent::canCreate() && ! SpmPengujian::query()->exists()` → hanya **1 record SPM aktif**.
- Form `FileUpload::make('image_path')` dengan rantai proteksi:
  - hanya `jpg/jpeg/png/webp`, `image`, `extensions`, `mimes`, `Rule::dimensions` (max 4096²);
  - `nestedRecursiveRule` → `AuthorizedSpmImageUpload` (validasi path lama aman untuk edit);
  - `maxSize(5120)` KB, `maxParallelUploads(1)`, disk `public`, direktori `pengujian/spm`;
  - `saveUploadedFileUsing` → `ConvertUploadedImageToWebp->execute()`; gagal → `InvalidUploadedImage` diterjemahkan jadi `ValidationException`.
- Table → `ImageColumn` dari `image_path`, paginasi nonaktif.

### 4.7 Halaman Pages (pola standar Filament)
Setiap resource punya 3 halaman, polanya sama:
- `List*` → extends `ListRecords`, menambahkan `CreateAction::make()` di header (kecuali `Sertifikasi` yang header action-nya kosong karena `canCreate=false`).
- `Create*` → extends `CreateRecord` (polos).
- `Edit*` → extends `EditRecord`, menambahkan `DeleteAction::make()` di header.
- Peran: file ini yang diregistrasikan oleh `getPages()` resource dan menentukan route (`/`, `/create`, `/{record}/edit`). Tidak ada logika bisnis di sini—semua aturan ada di Resource/Policy/Action.

### 4.8 Model
| Model | Relasi / logika |
|-------|-----------------|
| `AlurPengujian` | Plain model, `fillable = ['image']` |
| `Sertifikasi` | Plain model, `fillable = ['image']` |
| `RuangLingkup` | Konstanta `LAB_OPTIONS` (5 lab), helper `labOptions()`, `getLabLabel()`, `hasLabColumn()`, scope `orderedByLab()` (CASE-SQL urutan lab tetap) |
| `Lab` | Const `NAMES` (5 lab), relasi `komoditis()` & `parameters()` (HasMany) |
| `Komoditi` | `lab()` (BelongsTo), `parameters()` (HasMany) |
| `Parameter` | `lab()`, `komoditi()` (BelongsTo); cast `harga` → `integer` |
| `SpmPengujian` | `fillable = ['image_path']`; **event cleanup otomatis**: saat `updated`/`deleted`, hapus file lama dari `storage/public` jika terdeteksi sebagai file "managed" (`isManagedImagePath()` — regex path `pengujian/spm/{ULID}.webp`). Ini mencegah file menumpuk saat gambar diganti. |

### 4.9 Policy — `SpmPengujianPolicy.php`
- Semua method (`viewAny`, `view`, `create`, `update`, `delete`, `deleteAny`) mengecek `$user->isAdmin()` (role kolom `users.role`).
- `create()` tambahan: `! SpmPengujian::query()->exists()` → jaga hanya 1 record.
- Filament otomatis memakai policy ini karena konvensi penamaan `{Model}Policy` di `app/Policies`.
- Resource lain di cluster ini **tidak** punya policy → memakai kebijakan bawaan Filament (polos).
- **Mekanisme otorisasi ganda (penting):** user `humas` **bisa login** ke panel karena `User::canAccessPanel()` memeriksa `panelRoles()` = `[admin, humas]`. Namun `SpmPengujianPolicy` membatasi seluruh kelola SPM hanya untuk `isAdmin()`. Inilah mengapa `humas` bisa melihat dashboard tetapi **tidak** boleh kelola SPM — pembatasan terjadi di level policy, bukan di gate login.

### 4.10 Kelas Pendukung Upload SPM
> **Catatan arsitektur:** ketiga kelas di bawah **bukan spesifik Pengujian** — `ConvertUploadedImageToWebp` punya **8 direktori whitelist** (`pengujian/spm`, `kalibrasi/spm`, `sertifikasi-produk/spm`, `lph/spm`, `lsih/spm`, `verifikasi-tkdn/spm`, `pelatihan-teknis/spm`, `konsultasi-pendampingan/spm`) sehingga dipakai bersama oleh **semua menu SPM** lintas cluster. Pola yang sama berulang: tiap menu SPM punya resource + `{Model}Policy` paralel (mis. `SpmKalibrasiPolicy`, `SpmLphPolicy`, `SpmLsihPolicy`, dst — total 8 policy). Jadi mempelajari menu Pengujian = mempelajari pola menu SPM lain.
- `ConvertUploadedImageToWebp` — action yang di-inject ke `saveUploadedFileUsing`:
  1. Cek ekstensi GD + `imagewebp` tersedia.
  2. Validasi direktori target **whitelist** (`pengujian/spm`, dll) → cegah path traversal (`..`, `\`, null-byte, leading `/`).
  3. Validasi nama asli (tolak ekstensi PHP/`.phar`/`.phtml`).
  4. Validasi ukuran (≤5 MB), validasi isi via `getimagesize` + `finfo` MIME (cegah polyglot / MIME palsu).
  5. Decode via decoder by type, normalisasi orientasi EXIF JPEG (rotate/flip), konversi truecolor, `imagesavealpha`.
  6. Encode WebP kualitas 82, verifikasi header `RIFF....WEBP`.
  7. Simpan sebagai `pengujian/spm/{Str::ulid()}.webp` di disk `public`, verifikasi MIME hasil, hapus file jika gagal. → return `path`.
- `InvalidUploadedImage` — `RuntimeException` khusus; ditangkap resource menjadi pesan validasi form.
- `AuthorizedSpmImageUpload` — rule `ValidationRule`; jika nilai bukan `TemporaryUploadedFile` (artinya user tidak upload file baru, memakai path lama) → harus `hash_equals` dengan `originalPath` record lama, jika tidak → validasi gagal. Mencegah manipulasi path gambar oleh user.

---

## 5. Alur CRUD End-to-End (Contoh Nyata)

### 5.1 Kelola Tarif Pengujian (Komoditi + Parameter)
```
User klik "Tarif Pengujian"
  → ListKomoditis (GET /admin/pengujian/komoditis, eager load lab + count parameter)
  → klik "New Komoditi" → CreateKomoditi → form(core form()) → simpan ke komoditis
  → klik komoditi → EditKomoditi
      └─ tab "Parameter" → ParameterRelationManager
           ├─ New Parameter → simpan ke parameters (lab default = lab komoditi induk)
           └─ edit harga/meted → dehydrate 0→null → update
```
Data ini lalu dipakai frontend tab "Tarif" (`TarifPengujian` Livewire): pilih komoditi → query `parameters` paginate 10 → tampil harga.

### 5.2 Unggah SPM Pengujian
```
Create/Edit SPM (hanya admin, satu record)
  → upload jpg/png/webp ≤5MB ≤4096²
  → saveUploadedFileUsing → ConvertUploadedImageToWebp::execute()
       ├─ gagal gambar tidak valid → InvalidUploadedImage → ValidationException (form merah)
       └─ sukses → simpan path webp; record lama (jika ada) dihapus otomatis oleh event updated() SpmPengujian
```
Detail penting event cleanup: saat `EditSpmPengujian` mengganti gambar, `wasChanged('image_path')` true → `getRawOriginal('image_path')` dihapus dari disk, asalkan lolos `isManagedImagePath()` (hanya path hasil converter, bukan file lain yang mungkin direferensikan).

### 5.3 Alur & Sertifikat (hampir tanpa state)
- `AlurPengujianResource`: hanya boleh 1 gambar `alur_pengujian.jpg`; user lihat sebagai gambar alur di tab "Alur".
- `SertifikasiResource`: `canCreate=false`; record di-seed/DB. Frontend mengambil `Sertifikasi::first()`.

### 5.4 Ruang Lingkup
- Admin menambah baris `komoditi + ruang_lingkup (HTML) [+ lab]`.
- `orderedByLab()` mengurutkan tampilan tabel & frontend: jika kolom `lab` ada → urutan lab tetap (CASE-SQL) lalu alfabet per komoditi; jika tidak ada → alfabet per komoditi saja.
- Frontend membaca `RuangLingkup::labOptions()` dan `getLabLabel()` untuk menampilkan label lab, plus filter & pencarian client-side (Alpine.js). `ruang_lingkup` dirender sebagai HTML mentah via `x-html` (lihat catatan keamanan §4.4).

---

## 6. Alur Keterkaitan Frontend (Konsumsi Data)

```
routes/web.php
  GET /pengujian → PengujianController@index
       ├─ Sertifikasi::first()          → tab Sertifikat
       ├─ RuangLingkup::query()->orderedByLab()->get() → tab Ruang Lingkup
       ├─ AlurPengujian::first()        → tab Alur
       ├─ SpmPengujian::first()         → tab SPM
       └─ labOptions()                  → dropdown filter lab
       → view('pengujian')  (Alpine.js; tab Sertifikat default)
            └─ @livewire('tarif-pengujian') → TarifPengujian (Livewire)
                 → komoditis (id, nama) + parameters (nama, metode_uji, harga)
                 → livewire/tarif-pengujian.blade.php
```
Gambar diakses via path `storage/{image|image_path}` (disk public; pastikan `php artisan storage:link`).

---

## 7. Alat Bantu: Import Data Legacy

`app/Console/Commands/ImportParameters.php` (command `php artisan import:parameters`):
- Migrasi data lama `data_parameter` (CSV ber-header `id,nama,metode_uji,lab_id,komoditi_id,harga`) ke tabel `parameters`, pakai `upsert` per 500 baris.
- Opsi: `--dry-run`, `--truncate`, `--skip-invalid`; normalisasi harga (hapus non-digit, 0/`-`/`n/a` → `null`); cek FK valid (lab_id & komoditi_id harus ada).
- Peran: jembatan data legacy → struktur baru yang dipakai resource ini. Tidak dijalankan otomatis.

---

## 8. Ringkasan Alur "Siapa Memanggil Apa"

```
[Sidebar] ──► PengujianCluster (grup Pelayanan)
  ├─► AlurPengujianResource ──► AlurPengujian ──► table alur_pengujians
  ├─► SertifikasiResource   ──► Sertifikasi   ──► table sertifikasis
  ├─► RuangLingkupResource  ──► RuangLingkup  ──► table ruang_lingkups (+lab)
  ├─► KomoditiResource      ──► Komoditi ──┐
  │       └─ ParameterRelationManager ──► Parameter  ──► table parameters
  ├─► SpmPengujianResource  ──► SpmPengujian ──► SpmPengujianPolicy
  │       └─ [FileUpload] ──► ConvertUploadedImageToWebp
  │             ├─ InvalidUploadedImage (error)
  │             └─ AuthorizedSpmImageUpload (validasi path)
  └─► tables: labs, komoditis, parameters, ruang_lingkups, sertifikasis,
             alur_pengujians, spm_pengujians
       └─ migrated seats: LabSeeder (5 lab)
            └─ (opsional) ImportParameters – data parameter legacy
```

### Aturan bisnis yang berlaku (dirangkum dari file di atas)
1. **Satu record aktif**: alur pengujian (≤1), sertifikasi (create nonaktif, seed/DB), SPM (≤1 via policy + resource `canCreate`).
2. **Admin-only untuk SPM**; user `humas` (yang bisa masuk panel) tidak berhak.
3. **Seluruh file SPM harus WebP hasil converter** — tidak menyimpan file asli, hanya path hash/ULID.
4. **Harga parameter** disimpan integer Rupiah nullable; 0 disamakan dengan "tidak ada harga".
5. **5 lab tetap** dengan dua representasi berbeda (perlu dipahami, sering membingungkan):
   - `Lab::NAMES` (`app/Models/Lab.php`) = array **indexed** berisi label: `['Lab Lingkungan', 'Lab Kimia', 'Lab Mikro', 'Lab Udara', 'Lab Proses dan Bahan Bangunan']`. Digunakan `LabSeeder` dan tabel `labs`.
   - `RuangLingkup::LAB_OPTIONS` (`app/Models/RuangLingkup.php`) = array **asosiatif** dengan key slug: `['lab_lingkungan' => 'Lab Lingkungan', 'lab_kimia' => 'Lab Kimia', ...]`.
   - Label (value) konsisten di kedua konstanta, tapi **struktur/key berbeda**. Lebih penting lagi, kolom `lab` direpresentasikan **dua cara**:
     - `RuangLingkup.lab` = **slug string** (`lab_lingkungan`, dst) — **tanpa foreign key** (migrasi `2026_05_02_090000`: `$table->string('lab')`).
     - `Komoditi.lab_id` & `Parameter.lab_id` = **foreign key** ke `labs` (`->constrained('labs')->cascadeOnDelete()`).
   - Jadi antar tabel tidak ada FK yang menghubungkan slug `RuangLingkup.lab` dengan `labs.id` — konsistensi nilai sepenuhnya tanggung jawab aplikasi, bukan constraint DB.

---

## 9. Catatan Alur Khusus yang Perlu Diwaspadai

- **Pola `RuangLingkup` adaptif**: `hasLabColumn()` melakukan `Schema::hasColumn` sekali (cached via `??=`). Jika migrasi dijalankan setelah resource ter-cache, jalankan `php artisan optimize:clear` / `filament:cache-components` agar UI menyesuaikan. Ingat perilaku `orderedByLab()`: tanpa kolom lab → urut alfabet per komoditi; dengan kolom lab → urutan lab tetap + secondary alfabet per komoditi.
- **Cleanup gambar SPM**: hanya path yang lolos regex `pengujian/spm/{ULID}.webp` yang dihapus otomatis. File dari direktori lain (misal hasil upload manual) tidak dihapus—tidak menyebabkan error, hanya berpotensi jadi sampah storage.
- **`canCreate` & policy saling berlapis** pada SPM: resource membatasi tombol create, policy juga memaksa aturan yang sama di level otorisasi (tidak bisa disiasati lewat URL).
- Cluster memakai `SubNavigationPosition::Top` → saat hanya punya 5 submenu, semua tampil sebagai tab; menambah resource lain akan menambah tab (bukan menu dropdown).
- Resource `Komoditi` diberi label navigasi "Tarif Pengujian" tetapi model label "Komoditi" — keduanya bisa berbeda, Filament menggunakan keduanya untuk konteks berbeda (menu vs judul halaman).