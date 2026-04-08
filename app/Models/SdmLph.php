<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SdmLph extends Model
{
    protected $table = 'lph_sdm';

    protected $fillable = [
        'nama',
        'kategori',
    ];
}
