# Fitur Komoditi & Parameter Pengujian (Tarif)

## Latar Belakang

User memiliki 2 tabel dari database website lama:
- **`data_komoditi`** — 359 records (`id`, `nama`, `peraturan`, `id_lab`, `keterangan`)
- **`data_parameter`** — 2659 records (`id`, `nama`, `metode_uji`, `satuan`, `baku_mutu`, `id_lab`, `id_komoditi`, `Harga`)

Tujuan: User dapat memilih komoditi di halaman frontend (tab Tarif di `/pengujian`), lalu melihat parameter-parameter beserta harga terkait komoditi tersebut. Admin dapat mengelola data melalui Filament panel.

### Keputusan yang Sudah Dikonfirmasi

- **Import data legacy**: Manual (ekspor dari tabel lama, import ke tabel baru setelah migrasi)
- **Penempatan frontend**: Tab "Tarif" di halaman `pengujian.blade.php`
- **Lab**: Tabel baru `labs` dengan 5 record tetap (Lab Lingkungan, Lab Kimia, Lab Mikro, Lab Udara, Lab Proses dan Bahan Bangunan)
- **Frontend komoditi**: Hanya tampilkan `nama` (untuk dipilih user)
- **Frontend parameter**: Tampilkan `nama`, `metode_uji`, `satuan`, `harga`
- **Harga**: `unsignedInteger` dalam satuan rupiah

---

## Proposed Changes

### 1. Database — Migrations (3 tabel baru)

#### [NEW] `database/migrations/xxxx_create_labs_table.php`

```php
Schema::create('labs', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->timestamps();
});
```

#### [NEW] `database/migrations/xxxx_create_komoditis_table.php`

```php
Schema::create('komoditis', function (Blueprint $table) {
    $table->id();
    $table->string('nama')->index();
    $table->text('peraturan')->nullable();
    $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();
    $table->text('keterangan')->nullable();
    $table->timestamps();
});
```

#### [NEW] `database/migrations/xxxx_create_parameters_table.php`

```php
Schema::create('parameters', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('metode_uji')->nullable();
    $table->string('satuan')->nullable();
    $table->string('baku_mutu')->nullable();
    $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();
    $table->foreignId('komoditi_id')->constrained('komoditis')->cascadeOnDelete();
    $table->unsignedInteger('harga')->default(0);
    $table->timestamps();

    $table->index(['komoditi_id', 'lab_id']);
});
```

---

### 2. Database — Seeder (hanya untuk labs)

#### [NEW] `database/seeders/LabSeeder.php`

Menyemai 5 lab tetap:
1. Lab Lingkungan
2. Lab Kimia
3. Lab Mikro
4. Lab Udara
5. Lab Proses dan Bahan Bangunan

> [!NOTE]
> Data komoditi dan parameter tidak perlu seeder — user akan import manual dari database lama.

---

### 3. Models

#### [NEW] `app/Models/Lab.php`

- `$fillable`: `nama`
- Relationship: `hasMany(Komoditi::class)`, `hasMany(Parameter::class)`

#### [NEW] `app/Models/Komoditi.php`

- `$fillable`: `nama`, `peraturan`, `lab_id`, `keterangan`
- Relationships: `belongsTo(Lab::class)`, `hasMany(Parameter::class)`

#### [NEW] `app/Models/Parameter.php`

- `$fillable`: `nama`, `metode_uji`, `satuan`, `baku_mutu`, `lab_id`, `komoditi_id`, `harga`
- Relationships: `belongsTo(Komoditi::class)`, `belongsTo(Lab::class)`
- Cast: `'harga' => 'integer'`

---

### 4. Factories (untuk testing)

#### [NEW] `database/factories/LabFactory.php`

```php
public function definition(): array
{
    return [
        'nama' => fake()->unique()->randomElement([
            'Lab Lingkungan', 'Lab Kimia', 'Lab Mikro',
            'Lab Udara', 'Lab Proses dan Bahan Bangunan',
        ]),
    ];
}
```

#### [NEW] `database/factories/KomoditiFactory.php`

```php
public function definition(): array
{
    return [
        'nama' => fake()->words(3, true),
        'peraturan' => fake()->optional()->sentence(),
        'lab_id' => Lab::factory(),
        'keterangan' => fake()->optional()->sentence(),
    ];
}
```

#### [NEW] `database/factories/ParameterFactory.php`

```php
public function definition(): array
{
    return [
        'nama' => fake()->words(2, true),
        'metode_uji' => fake()->optional()->word(),
        'satuan' => fake()->randomElement(['mg/L', 'pH', '%', 'NTU', 'mg/kg']),
        'baku_mutu' => fake()->optional()->word(),
        'lab_id' => Lab::factory(),
        'komoditi_id' => Komoditi::factory(),
        'harga' => fake()->numberBetween(50000, 500000),
    ];
}
```

---

### 5. Filament Admin Panel — Pengujian Cluster

#### [NEW] `app/Filament/Clusters/Pengujian/Resources/KomoditiResource.php`

Resource di dalam cluster Pengujian yang sudah ada:
- **Form**: `nama` (TextInput, required), `lab_id` (Select dari Lab model, searchable), `peraturan` (Textarea), `keterangan` (Textarea)
- **Table**: `nama` (searchable), `lab.nama` (badge, filterable via SelectFilter), `parameters_count` (withCount), `created_at`
- **Actions**: Edit, Delete
- **Relation Manager**: `ParameterRelationManager`

#### [NEW] `app/Filament/Clusters/Pengujian/Resources/KomoditiResource/RelationManagers/ParameterRelationManager.php`

Relation manager di halaman Edit komoditi:
- **Table columns**: `nama` (searchable), `metode_uji`, `satuan`, `baku_mutu`, `harga` (formatted Rp)
- **Form fields**: `nama`, `metode_uji`, `satuan`, `baku_mutu`, `lab_id` (Select), `harga` (TextInput, numeric, prefix Rp)
- **Actions**: Create, Edit, Delete, BulkDelete

#### [NEW] Pages: `ListKomoditis.php`, `CreateKomoditi.php`, `EditKomoditi.php`

Standard CRUD pages mengikuti pola existing (redirect ke index setelah create/edit).

> [!NOTE]
> **Parameter tidak punya resource terpisah** — dikelola melalui RelationManager di dalam KomoditiResource. Admin klik komoditi → lihat & kelola semua parameter terkait.

---

### 6. Frontend — Livewire Component

#### [NEW] `app/Livewire/TarifPengujian.php`

```php
class TarifPengujian extends Component
{
    public ?int $komoditiId = null;

    public function render(): View
    {
        $komoditis = Komoditi::query()
            ->select(['id', 'nama'])
            ->orderBy('nama')
            ->get();

        $parameters = $this->komoditiId
            ? Parameter::query()
                ->where('komoditi_id', $this->komoditiId)
                ->select(['id', 'nama', 'metode_uji', 'satuan', 'harga'])
                ->orderBy('nama')
                ->get()
            : collect();

        return view('livewire.tarif-pengujian', compact('komoditis', 'parameters'));
    }
}
```

Key design:
- Dropdown komoditi menggunakan **Alpine.js searchable select** (359 items, ringan)
- Parameter di-fetch **on-demand** via Livewire saat komoditi dipilih
- Harga diformat dengan `Number::currency($harga, 'IDR', 'id')`
- Style konsisten dengan design pengujian.blade.php yang sudah ada

#### [NEW] `resources/views/livewire/tarif-pengujian.blade.php`

Blade view berisi:
1. Searchable dropdown komoditi dengan Alpine.js
2. Tabel parameter (nama, metode uji, satuan, harga)
3. Empty state saat belum memilih komoditi
4. Transisi animasi saat data berubah

#### [MODIFY] `resources/views/pengujian.blade.php`

Mengubah section tab "Tarif" (line 294-346) dari disabled placeholder menjadi:

```blade
<section x-show="tab === 'tarif'" x-transition.opacity.duration.300ms style="display: none;">
    <div class="mx-auto max-w-5xl space-y-8">
        <div class="rounded-[24px] border border-black/10 bg-slate-50 p-5 sm:rounded-[30px] sm:p-8">
            <!-- Info peraturan tetap dipertahankan -->
        </div>
        @livewire('tarif-pengujian')
    </div>
</section>
```

---

### 7. Testing (fokus utama)

#### [NEW] `tests/Feature/Filament/Pengujian/KomoditiResourceTest.php`

| # | Test | Deskripsi |
|---|------|-----------|
| 1 | `test_can_render_list_page` | Halaman list komoditi bisa dimuat (200 OK) |
| 2 | `test_can_list_komoditis` | Tabel menampilkan data komoditi |
| 3 | `test_can_render_create_page` | Halaman create bisa dimuat |
| 4 | `test_can_create_komoditi` | Create berhasil + assertDatabaseHas |
| 5 | `test_can_validate_required_fields` | Validasi required name gagal tanpa nama |
| 6 | `test_can_render_edit_page` | Edit page memuat data existing |
| 7 | `test_can_update_komoditi` | Update berhasil |
| 8 | `test_can_delete_komoditi` | Delete berhasil + cascade parameter |
| 9 | `test_can_search_komoditis` | Search table bekerja |
| 10 | `test_can_filter_by_lab` | Filter lab di tabel bekerja |

#### [NEW] `tests/Feature/Filament/Pengujian/ParameterRelationManagerTest.php`

| # | Test | Deskripsi |
|---|------|-----------|
| 1 | `test_can_render_relation_manager` | Relation manager di edit page dimuat |
| 2 | `test_can_list_parameters` | Parameter komoditi muncul di RM |
| 3 | `test_can_create_parameter` | Create parameter via RM |
| 4 | `test_can_edit_parameter` | Edit parameter via RM |
| 5 | `test_can_delete_parameter` | Delete parameter via RM |
| 6 | `test_can_search_parameters` | Search di RM bekerja |

#### [NEW] `tests/Feature/Livewire/TarifPengujianTest.php`

| # | Test | Deskripsi |
|---|------|-----------|
| 1 | `test_component_can_render` | Component dimuat tanpa error |
| 2 | `test_displays_komoditi_list` | Dropdown menampilkan daftar komoditi |
| 3 | `test_shows_parameters_when_komoditi_selected` | Parameter muncul setelah pilih komoditi |
| 4 | `test_shows_empty_state_when_no_selection` | Empty state saat belum pilih |
| 5 | `test_shows_formatted_prices` | Harga tampil dalam format Rupiah |
| 6 | `test_only_shows_parameters_for_selected_komoditi` | Hanya parameter terkait yang muncul |

#### [NEW] `tests/Feature/PengujianPageTest.php`

| # | Test | Deskripsi |
|---|------|-----------|
| 1 | `test_pengujian_page_loads_successfully` | `/pengujian` returns 200 |
| 2 | `test_page_contains_livewire_component` | Halaman memuat Livewire tarif component |

---

## Verification Plan

### Automated Tests

```bash
# Test fitur baru
php artisan test --compact --filter=Komoditi
php artisan test --compact --filter=Parameter
php artisan test --compact --filter=TarifPengujian
php artisan test --compact --filter=PengujianPage

# Code style
vendor/bin/pint --dirty --format agent

# Full suite (setelah semua test pass)
php artisan test --compact
```

### File Summary

| Kategori | File Baru | File Modified |
|----------|-----------|---------------|
| Migrations | 3 | 0 |
| Models | 3 | 0 |
| Factories | 3 | 0 |
| Seeders | 1 | 0 |
| Filament Resources | 6 (Resource + RM + 3 Pages) | 0 |
| Livewire | 1 component + 1 view | 0 |
| Frontend | 0 | 1 (`pengujian.blade.php`) |
| Tests | 4 | 0 |
| **Total** | **17 files baru** | **1 file modified** |
