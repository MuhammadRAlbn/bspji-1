<?php

namespace App\Models;

use Database\Factories\AlurKalibrasiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurKalibrasi extends Model
{
    /** @use HasFactory<AlurKalibrasiFactory> */
    use HasFactory;

    protected $fillable = ['image'];
}
