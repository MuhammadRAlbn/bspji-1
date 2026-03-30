<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SejarahSingkat extends Model
{
    protected $fillable = [
        'tahun',
        'judul',
        'detail',
        'gambar',
    ];
}
