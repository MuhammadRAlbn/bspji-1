<?php

namespace App\Models;

use Database\Factories\RuangLingkupKalibrasiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLingkupKalibrasi extends Model
{
    /** @use HasFactory<RuangLingkupKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['title', 'image', 'details'];

    protected $casts = [
        'details' => 'array',
    ];
}
