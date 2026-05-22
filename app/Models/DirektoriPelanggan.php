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
}
