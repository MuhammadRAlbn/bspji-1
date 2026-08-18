# Peta Penyebaran Pelanggan Dinamis

Mengganti data statis (dummy) pada peta penyebaran pelanggan di `welcome.blade.php` dengan data real dari database, berdasarkan tabel `legacy_users`, `tbl_provinsi`, dan `tbl_kabupaten`.

## Proposed Changes

### 1. Migration — Tambah Kolom Koordinat

#### [NEW] `add_coordinates_to_tbl_kabupaten_table.php`

Menambahkan kolom `latitude` dan `longitude` (decimal 10,7) ke tabel `tbl_kabupaten`. Kolom nullable karena tidak semua kabupaten perlu diisi koordinat.

---

### 2. Seeder — Isi Koordinat Kabupaten yang Memiliki Pelanggan

#### [NEW] `KabupatenCoordinateSeeder.php`

Seeder untuk mengisi koordinat latitude/longitude **hanya untuk 38 kabupaten/kota** yang saat ini memiliki pelanggan di `legacy_users`. Koordinat ini berdasarkan ibu kota kabupaten/kota.

Daftar kabupaten yang akan di-seed (diurutkan berdasarkan jumlah pelanggan):

| Kode | Kabupaten/Kota | Provinsi | Pelanggan |
|------|---------------|----------|-----------|
| 1171 | KOTA BANDA ACEH | ACEH | 282 |
| 1106 | KAB. ACEH BESAR | ACEH | 98 |
| 1105 | KAB. ACEH BARAT | ACEH | 60 |
| 1173 | KOTA LHOKSEUMAWE | ACEH | 37 |
| 1115 | KAB. NAGAN RAYA | ACEH | 31 |
| 1107 | KAB. PIDIE | ACEH | 29 |
| 1108 | KAB. ACEH UTARA | ACEH | 26 |
| 1112 | KAB. ACEH BARAT DAYA | ACEH | 20 |
| 1111 | KAB. BIREUEN | ACEH | 16 |
| 1101 | KAB. ACEH SELATAN | ACEH | 15 |
| ... | _(+28 kabupaten lainnya)_ | | |

---

### 3. Route — Query Agregasi Pelanggan per Kabupaten

#### [MODIFY] [web.php](file:///c:/laragon/www/bspji-1/routes/web.php)

Menambahkan query di closure route `/` untuk mengambil data distribusi pelanggan:
- JOIN `legacy_users` → `tbl_kabupaten` → `tbl_provinsi`
- GROUP BY `kode_kabupaten`
- SELECT `nama_kabupaten`, `nama_provinsi`, `latitude`, `longitude`, `COUNT(*) as total`
- Filter hanya kabupaten yang memiliki koordinat (`whereNotNull('latitude')`)
- Pass hasilnya sebagai `$customerDistribution` ke view

---

### 4. View — Ganti Dummy Data dengan Data Dinamis

#### [MODIFY] [welcome.blade.php](file:///c:/laragon/www/bspji-1/resources/views/welcome.blade.php)

- Menghapus array `customerDistributionDummyData` di JavaScript
- Meng-inject `$customerDistribution` dari PHP ke JavaScript via `@json()`
- Update label "Total Dummy" menjadi "Total" di sidebar kartu
- Selebihnya logika Leaflet marker tetap sama (warna, ukuran, tooltip)

---

## Verification Plan

### Automated Tests
- `php artisan migrate` — pastikan migrasi berhasil
- `php artisan db:seed --class=KabupatenCoordinateSeeder` — pastikan seeder berjalan
- Verifikasi data: query tinker untuk cek koordinat terisi

### Manual Verification
- Buka halaman landing, scroll ke section "Peta Penyebaran Pelanggan"
- Pastikan marker muncul di posisi yang benar
- Pastikan tooltip menampilkan nama kabupaten, provinsi, dan jumlah pelanggan aktual
- Pastikan kartu "Total" dan "Coverage" menampilkan angka real
