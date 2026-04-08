<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPublikProduk extends Model
{
    protected $fillable = [
        'nama',
        'file_path',
    ];
}
