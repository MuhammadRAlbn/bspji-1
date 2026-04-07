<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurKalibrasi extends Model
{
    /** @use HasFactory<\Database\Factories\AlurKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
