# Error Yang Dihadapi

## 1. Class "Filament\Forms\Components\Section" not found

### Deskripsi Error
Muncul pesan error `Class "Filament\Forms\Components\Section" not found` pada file-file Resource di dalam cluster LSIH, khususnya saat mencoba memanggil `Section::make()`.

### Penyebab
Error ini terjadi karena adanya kesalahan dalam penggunaan `use` statement (import namespace). Pada proyek ini, komponen layout `Section` tidak berada di bawah namespace standar Filament Forms (`Filament\Forms\Components\Section`), melainkan dipindahkan ke layer **Schemas** khusus proyek ini.

- **Namespace Salah**: `Filament\Forms\Components\Section`
- **Namespace Benar**: `Filament\Schemas\Components\Section`

Hal ini kemungkinan besar dikarenakan arsitektur proyek yang memisahkan definisi logic form/table ke dalam layer `Schemas` untuk meningkatkan reusability dan kerapihan kode (seperti yang terlihat pada pola cluster lainnya di proyek ini).

### Solusi
Mengubah baris import di bagian atas file Resource sebagai berikut:

```php
// Dari:
use Filament\Forms\Components\Section;

// Menjadi:
use Filament\Schemas\Components\Section;
```

Perbaikan ini telah diterapkan pada:
- `LsihRuangLingkupResource.php`
- `LsihAlurResource.php`
- `LsihTarifResource.php`
