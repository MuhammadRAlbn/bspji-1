# Arahan: Membuat API Endpoint di Laravel

Panduan ini berisi langkah-langkah yang perlu Anda lakukan di **projek Laravel** (`bspjiaceh.kemenperin.go.id`) untuk membuat 2 endpoint API penyimpanan data penilaian petugas dan NPS.

---

## Langkah 1: Buat Model `Pelayanan`

Jalankan command artisan:
```bash
php artisan make:model Pelayanan
```

Kemudian edit file `app/Models/Pelayanan.php` menjadi:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'pelayanan';

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     */
    protected $fillable = [
        'tingkat_pelayanan',
        'petugas_upp',
    ];

    /**
     * Menunjukkan bahwa model ini menggunakan timestamps.
     * Laravel akan otomatis mengisi 'created_at' dan 'updated_at'.
     * Jika tabel Anda TIDAK punya kolom 'updated_at', set ke false
     * dan gunakan CREATED_AT constant saja.
     */
    public $timestamps = true;

    // Jika tabel hanya punya 'created_at' tanpa 'updated_at', uncomment baris berikut:
    // const UPDATED_AT = null;
}
```

> [!IMPORTANT]
> Jika tabel `pelayanan` hanya memiliki kolom `created_at` **tanpa** `updated_at`, Anda **harus** uncomment baris `const UPDATED_AT = null;`. Jika tidak, Laravel akan error karena mencoba menulis ke kolom `updated_at` yang tidak ada.

---

## Langkah 2: Buat Model `TblNps`

Jalankan command artisan:
```bash
php artisan make:model TblNps
```

Kemudian edit file `app/Models/TblNps.php` menjadi:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblNps extends Model
{
    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'tbl_nps';

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     */
    protected $fillable = [
        'nps',
    ];

    /**
     * Timestamps setting.
     */
    public $timestamps = true;

    // Jika tabel hanya punya 'created_at' tanpa 'updated_at', uncomment baris berikut:
    // const UPDATED_AT = null;
}
```

---

## Langkah 3: Buat Controller `PenilaianPetugasController`

Jalankan command artisan:
```bash
php artisan make:controller Api/PenilaianPetugasController
```

Kemudian edit file `app/Http/Controllers/Api/PenilaianPetugasController.php` menjadi:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenilaianPetugasController extends Controller
{
    /**
     * Menyimpan data petugas terpilih.
     *
     * Menerima POST request dengan parameter:
     * - petugas_upp (string, required) — nama petugas yang dipilih
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'petugas_upp' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // Simpan ke tabel 'pelayanan'
            $pelayanan = Pelayanan::create([
                'petugas_upp' => $request->input('petugas_upp'),
                // 'tingkat_pelayanan' dikosongkan (nullable) 
                // atau isi default jika diperlukan
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data petugas berhasil disimpan',
                'data'    => $pelayanan,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
```

---

## Langkah 4: Buat Controller `NpsController`

Jalankan command artisan:
```bash
php artisan make:controller Api/NpsController
```

Kemudian edit file `app/Http/Controllers/Api/NpsController.php` menjadi:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TblNps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NpsController extends Controller
{
    /**
     * Menyimpan skor NPS.
     *
     * Menerima POST request dengan parameter:
     * - nps (integer, required, 0-10) — skor Net Promoter Score
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nps' => 'required|integer|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // Simpan ke tabel 'tbl_nps'
            $nps = TblNps::create([
                'nps' => $request->input('nps'),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Skor NPS berhasil disimpan',
                'data'    => $nps,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
```

---

## Langkah 5: Tambahkan Route API

Edit file `routes/api.php` dan tambahkan baris berikut:

```php
use App\Http\Controllers\Api\PenilaianPetugasController;
use App\Http\Controllers\Api\NpsController;

// ============================================
// API untuk Layar UPP (Penilaian Petugas & NPS)
// ============================================
Route::post('/penilaian-petugas/store', [PenilaianPetugasController::class, 'store']);
Route::post('/nps/store', [NpsController::class, 'store']);
```

> [!NOTE]
> Laravel secara otomatis menambahkan prefix `/api` pada route yang ada di file `routes/api.php`. Sehingga URL finalnya adalah:
> - `POST https://bspjiaceh.kemenperin.go.id/api/penilaian-petugas/store`
> - `POST https://bspjiaceh.kemenperin.go.id/api/nps/store`

---

## Langkah 6: Nonaktifkan CSRF untuk Route API (Jika Perlu)

> [!WARNING]
> Secara default, Laravel melindungi semua POST request dengan CSRF token. Route di `routes/api.php` biasanya sudah **dikecualikan** dari CSRF. Namun, jika Anda mendapat error **419 (CSRF token mismatch)**, pastikan bahwa middleware group `api` tidak menggunakan `VerifyCsrfToken`.

**Untuk Laravel 11+**, cek file `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    // Route API biasanya sudah otomatis tanpa CSRF
})
```

**Untuk Laravel 10 dan sebelumnya**, cek file `app/Http/Kernel.php`:
```php
protected $middlewareGroups = [
    'api' => [
        // Pastikan TIDAK ada \App\Http\Middleware\VerifyCsrfToken di sini
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
```

---

## Langkah 7: Konfigurasi CORS

Pastikan server Laravel mengizinkan request dari domain `upp.bspjiaceh.id`.

**Untuk Laravel 11+**, edit `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        'api/*', // Kecualikan semua API route dari CSRF
    ]);
})
```

**Untuk Laravel 10 dan sebelumnya**, edit file `config/cors.php`:
```php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://upp.bspjiaceh.id'],
    // Atau gunakan ['*'] untuk mengizinkan semua origin
    'allowed_headers' => ['*'],
    'supports_credentials' => false,
];
```

> [!TIP]
> Karena request sebenarnya datang dari `proxy.php` (server-to-server via cURL), CORS seharusnya bukan masalah. Tapi konfigurasi ini tetap disarankan jika di kemudian hari ingin mengirim request langsung dari browser.

---

## Langkah 8: Testing

Setelah semua file ditambahkan, clear cache Laravel:

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

Lalu test dengan curl:

```bash
# Test simpan petugas
curl -X POST https://bspjiaceh.kemenperin.go.id/api/penilaian-petugas/store \
  -H "Accept: application/json" \
  -d "petugas_upp=irham"

# Response yang diharapkan (HTTP 201):
# {"status":"success","message":"Data petugas berhasil disimpan","data":{...}}

# Test simpan NPS
curl -X POST https://bspjiaceh.kemenperin.go.id/api/nps/store \
  -H "Accept: application/json" \
  -d "nps=8"

# Response yang diharapkan (HTTP 201):
# {"status":"success","message":"Skor NPS berhasil disimpan","data":{...}}
```

---

## Ringkasan File yang Perlu Dibuat/Edit

| Aksi | File | Keterangan |
|------|------|------------|
| **BUAT** | `app/Models/Pelayanan.php` | Model untuk tabel `pelayanan` |
| **BUAT** | `app/Models/TblNps.php` | Model untuk tabel `tbl_nps` |
| **BUAT** | `app/Http/Controllers/Api/PenilaianPetugasController.php` | Controller store petugas |
| **BUAT** | `app/Http/Controllers/Api/NpsController.php` | Controller store NPS |
| **EDIT** | `routes/api.php` | Tambah 2 route POST |
| **CEK** | CORS & CSRF config | Pastikan API route tidak diblokir |
