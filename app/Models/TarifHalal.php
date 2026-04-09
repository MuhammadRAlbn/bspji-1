<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifHalal extends Model
{
    protected $fillable = [
        'nama_tarif',
        'file_iframe',
        'file_download',
    ];
}
