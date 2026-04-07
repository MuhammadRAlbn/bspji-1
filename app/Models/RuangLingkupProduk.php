<?php

namespace App\Models;

use Database\Factories\RuangLingkupProdukFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLingkupProduk extends Model
{
    /** @use HasFactory<RuangLingkupProdukFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
