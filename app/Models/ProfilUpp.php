<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilUpp extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'moto_pelayanan_path',
        'foto_petugas_path',
        'tupoksi',
        'waktu_pelayanan',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'waktu_pelayanan' => 'array',
    ];
}
