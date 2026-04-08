<?php

namespace App\Models;

use Database\Factories\SertifikasiKalibrasiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikasiKalibrasi extends Model
{
    /** @use HasFactory<SertifikasiKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
