<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UppVisiMisi extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'visi',
        'misi',
        'moto',
    ];
}
