# Panduan Pemindahan Resource Filament ke dalam Cluster

Dokumen ini menjelaskan langkah-langkah teknis untuk memindahkan Filament Resource dari folder default (`app/Filament/Resources`) ke dalam sebuah **Cluster** (`app/Filament/Clusters`).

## Langkah-Langkah Teknis

### 1. Relokasi Fisik (Move Files)
Langkah pertama adalah memindahkan file resource beserta folder halamannya. Pada Filament v3, resource dan halamannya terikat sangat kuat. Jika hanya file resource yang dipindah, halamannya akan gagal dimuat.

- **File Resource** pindah ke: `app/Filament/Clusters/{NamaCluster}/Resources/{NamaResource}.php`
- **Folder Pages** pindah ke: `app/Filament/Clusters/{NamaCluster}/Resources/{NamaResource}/Pages/`

### 2. Sinkronisasi Namespace (Refactoring)
PHP dan Laravel sangat bergantung pada namespace. Saat file dipindah, namespace di setiap file **wajib** diubah agar sesuai dengan struktur folder yang baru.

- **Dari**: `namespace App\Filament\Resources\{NamaResource};`
- **Menjadi**: `namespace App\Filament\Clusters\{NamaCluster}\Resources\{NamaResource};`

> [!IMPORTANT]
> Perubahan ini harus dilakukan di file Resource utama dan SEMUA file di dalam folder `Pages`.

### 3. Registrasi Cluster
Tambahkan properti `$cluster` di dalam class Resource agar Filament mengenali kepemilikan resource tersebut:

```php
protected static ?string $cluster = NamaClusterCluster::class;
```

### 4. Perbaikan Import (Use Statements)
Periksa semua baris `use` di bagian atas file. Karena lokasi file resource berubah, file-file di dalam folder `Pages` (seperti `ListRecords`, `EditRecord`) harus memperbarui cara mereka meng-import class Resource utamanya.

---

## Tips Instruksi untuk AI Agent (Prompt)

Gunakan instruksi spesifik berikut agar AI Agent berhasil melakukan pemindahan tanpa error:

> "Pindahkan Filament Resource `{NamaResource}` ke dalam Cluster `{NamaCluster}`. Ikuti langkah ini:
> 1. Pindahkan file `{NamaResource}.php` dan folder `Pages/` terkait ke `app/Filament/Clusters/{NamaCluster}/Resources`.
> 2. Sesuaikan `namespace` di SEMUA file yang dipindahkan agar merujuk ke path `App\Filament\Clusters\{NamaCluster}\Resources`.
> 3. Di dalam class Resource, tambahkan `protected static ?string $cluster = {NamaCluster}Cluster::class;`.
> 4. Jika menggunakan Windows, gunakan perintah PowerShell `Move-Item` dan pastikan `use` statement di folder `Pages` sudah diperbarui ke namespace yang baru."

## Mengapa AI Agent Sering Gagal?
1. **Hanya Memindah File**: Sering lupa memindahkan folder `Pages`.
2. **Lupa Namespace**: Memindahkan file tapi membiarkan namespace lama (`Class not found` error).
3. **Lupa Hubungan Balik**: Memindahkan Resource tapi lupa memperbarui rujukan class Resource di dalam file-file di folder `Pages`.