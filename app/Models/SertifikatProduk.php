<?php

namespace App\Models;

use Database\Factories\SertifikatProdukFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatProduk extends Model
{
    /** @use HasFactory<SertifikatProdukFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
