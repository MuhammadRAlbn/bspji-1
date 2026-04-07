<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLingkupKalibrasi extends Model
{
    /** @use HasFactory<\Database\Factories\RuangLingkupKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['title', 'image', 'details'];

    protected $casts = [
        'details' => 'array',
    ];
}
