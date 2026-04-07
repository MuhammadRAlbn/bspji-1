<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikasiKalibrasi extends Model
{
    /** @use HasFactory<\Database\Factories\SertifikasiKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
