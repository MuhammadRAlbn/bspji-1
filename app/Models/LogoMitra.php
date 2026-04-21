<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogoMitra extends Model
{
    public const TYPE_LOGO = 'logo';

    public const TYPE_PELENGKAP = 'pelengkap';

    protected $fillable = [
        'tipe',
        'gambar',
        'singleton_key',
    ];
}
