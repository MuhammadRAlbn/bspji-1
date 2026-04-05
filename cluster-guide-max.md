Berikut versi **Markdown yang sudah diperluas** dengan tambahan konteks error dan knowledge base tanpa mengurangi isi sebelumnya:

````markdown
## Alur Menggunakan Clusters di Filament 5

Berikut adalah alur lengkap untuk menggunakan **Clusters di Filament 5** guna mengelompokkan resource dan halaman kustom agar lebih terorganisir:

---

### 1. Konfigurasi Awal Panel

Sebelum membuat cluster pertama, Anda harus memberitahu panel di mana lokasi kelas cluster akan disimpan.

Gunakan metode:

- `discoverClusters()`

Metode ini biasanya diletakkan bersamaan dengan:

- `discoverResources()`
- `discoverPages()`

---

### 2. Membuat Cluster

Gunakan perintah Artisan berikut untuk membuat kelas cluster baru:

```bash
php artisan make:filament-cluster
````

Perintah ini akan membuat file cluster baru di direktori:

```
app/Filament/Clusters
```

Di dalam file ini, Anda bisa menentukan properti navigasi seperti:

* `$navigationIcon`
* `$navigationLabel`
* `$navigationSort`
* `$navigationGroup`

Properti tersebut digunakan untuk mengatur tampilan cluster di sidebar utama.

---

### 3. Menambahkan Resource atau Halaman ke Cluster

Setelah cluster dibuat, Anda perlu mendaftarkan resource atau halaman kustom ke dalam cluster tersebut:

1. Buka kelas resource atau halaman yang ingin dimasukkan.
2. Definisikan properti:

```php
protected static ?string $cluster = Settings::class;
```

---

### 4. Rekomendasi Struktur Kode

Filament merekomendasikan agar Anda memindahkan resource dan halaman yang tergabung dalam sebuah cluster ke dalam direktori dengan nama yang sama dengan cluster tersebut.

Contoh:

```
app/Filament/Clusters/Settings/Resources
```

Jika Anda menggunakan perintah:

```bash
php artisan make:filament-resource
```

Saat cluster sudah ada, Filament akan:

* Menawarkan opsi untuk otomatis membuat resource di dalam direktori cluster
* Mengisi properti `$cluster` secara otomatis

---

### 5. Penyesuaian Tampilan (Opsional)

Setelah cluster aktif, beberapa perubahan visual akan terjadi secara otomatis:

#### Navigasi

* Item navigasi individu dari resource akan hilang dari sidebar utama
* Digantikan oleh satu item navigasi cluster

#### Sub-Navigasi

* Akan muncul menu sub-navigasi di dalam setiap halaman resource
* Posisi dapat diatur menggunakan properti:

```php
$subNavigationPosition
```

Nilai yang tersedia:

* `Start`
* `End`
* `Top`

#### Breadcrumbs

* Nama cluster akan muncul di breadcrumbs
* Dapat diubah menggunakan properti:

```php
$clusterBreadcrumb
```

#### URL

* URL resource akan otomatis mendapatkan awalan (prefix) nama cluster

---

## ⚠️ Troubleshooting & Error yang Sering Terjadi

Berikut adalah rangkuman error yang umum terjadi saat menggunakan Cluster di Filament 5 beserta penyebabnya:

### 1. Kesalahan Tipe Data pada `$navigationGroup`

* Terjadi karena deklarasi tipe data pada kelas Cluster tidak sesuai dengan kontrak dari kelas induk Filament.
* Biasanya disebabkan oleh penggunaan type hint seperti `?string`.

---

### 2. Kesalahan Nullable Type pada `$resource`

* Terjadi pada halaman Resource (misalnya `CreateRecord`, `EditRecord`, dll).
* Properti `$resource` **wajib bertipe `string` (tidak boleh nullable)**.
* Penyebab: kelas induk Filament tidak mengizinkan nilai `null`.

---

### 3. Kesalahan Namespace (Class Not Found)

* Terjadi setelah memindahkan Resource dan Pages ke dalam folder Cluster.
* Penyebab utama:

  * Namespace di bagian atas file tidak diperbarui
  * Import (`use`) tidak sesuai dengan struktur folder baru

---

## 📚 Panduan Pengetahuan (Knowledge Base)

Gunakan aturan berikut agar implementasi Filament 5 lebih stabil dan minim error:

---

### 1. Aturan Penulisan Properti (Type Hinting)

#### ✅ Prioritaskan Tanpa Tipe Data

Untuk menghindari Fatal Error akibat ketidakcocokan tipe:

```php
protected static $navigationGroup = 'Settings';
```

❌ Hindari:

```php
protected static ?string $navigationGroup = 'Settings';
```

---

#### ⚠️ Urutan Union Type Harus Tepat

Jika menggunakan tipe pada `$navigationIcon`, urutan wajib:

```
BackedEnum | string | null
```

Jangan mengubah urutan tersebut.

---

#### 🔒 Properti `$resource` pada Pages

Harus selalu:

```php
protected static string $resource;
```

❌ Tidak boleh:

```php
protected static ?string $resource;
```

---

### 2. Struktur Cluster dan Namespace

#### 📁 Sinkronisasi Folder

Gunakan struktur berikut untuk Namespace:

```
app\Filament\Clusters\[NamaCluster]/Resources
```

---

#### 🧭 Update Namespace

Setiap file yang dipindahkan wajib diperbarui:

```php
use App\Filament\Clusters\[NamaCluster]\Resources\[NamaResource]\Pages;
```

---

#### 🔗 Update Import (`use`)

Pastikan pada method `getPages()` di Resource:

* Semua class Page mengarah ke namespace yang benar
* Tidak ada referensi lama

---

### 3. Properti Navigasi Cluster

Secara default:

* Hanya `$navigationIcon` yang muncul

Properti lain harus ditambahkan manual:

```php
protected static $navigationLabel = 'Settings';
protected static $navigationSort = 1;
protected static $navigationGroup = 'System';
```

---

### 4. Lokasi Registrasi

Pastikan Cluster sudah terdaftar di Panel Provider (biasanya `AdminPanelProvider`):

```php
->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
```

Jika tidak didaftarkan:

* Cluster tidak akan muncul
* Resource di dalam cluster tidak dikenali

---

## ✅ Catatan Penting

* Jangan terlalu bergantung pada type hint di Filament → lebih aman tanpa tipe
* Selalu cek ulang namespace setelah refactor folder
* Error Filament sering bersifat **silent misconfiguration**, bukan syntax error
* Struktur folder = kunci utama stabilitas implementasi cluster

---

```

Kalau mau, langkah selanjutnya kita bisa naik level lagi: saya bisa bantu ubah ini jadi **prompt khusus untuk AI agent (Cursor / Copilot / GPT)** supaya dia otomatis tidak mengulangi error-error ini 👍
```
