<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirektoriPelanggan extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'merek',
        'tahun_sertifikasi',
        'no_sertifikat',
        'gambar',
        'no_hp',
        'keterangan',
        'is_active',
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the shortened address (City/Regency, Province)
     */
    public function getAlamatSingkatAttribute(): string
    {
        if (! $this->alamat) {
            return '-';
        }

        // Cari Kabupaten/Kota
        if (preg_match('/(?:Kab\.|Kabupaten|Kota)\s+([^,]+)/i', $this->alamat, $matches)) {
            $kabKota = trim($matches[1]);

            // Hanya hapus jika eksplisit ada kata 'Provinsi' atau 'Prov.' sebelum 'Aceh'
            // untuk menghindari terhapusnya kata 'Aceh' pada nama seperti 'Aceh Utara' atau 'Banda Aceh'.
            $kabKota = preg_replace('/\s*(?:Provinsi|Prov\.)\s*Aceh/i', '', $kabKota);
            $kabKota = trim($kabKota);

            return "{$kabKota}, Aceh";
        }

        return str($this->alamat)->limit(30); // fallback
    }
}
