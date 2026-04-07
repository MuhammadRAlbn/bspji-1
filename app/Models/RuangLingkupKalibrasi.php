<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLingkupKalibrasi extends Model
{
    /** @use HasFactory<\Database\Factories\RuangLingkupKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['komoditi', 'ruang_lingkup'];
}
