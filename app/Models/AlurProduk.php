<?php

namespace App\Models;

use Database\Factories\AlurProdukFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurProduk extends Model
{
    /** @use HasFactory<AlurProdukFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
