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
