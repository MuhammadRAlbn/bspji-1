<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionTestimoni extends Model
{
    protected $fillable = [
        'gambar_pelanggan',
        'nama',
        'jabatan',
        'nama_perusahaan',
        'pesan',
    ];
}
