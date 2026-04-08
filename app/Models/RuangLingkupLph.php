<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuangLingkupLph extends Model
{
    protected $table = 'lph_ruang_lingkup';

    protected $fillable = [
        'gambar',
        'nama',
    ];
}
