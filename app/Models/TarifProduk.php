<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifProduk extends Model
{
    protected $fillable = [
        'nama_dokumen',
        'file_path',
    ];
}
