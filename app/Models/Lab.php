<?php

namespace App\Models;

use Database\Factories\LabFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lab extends Model
{
    /** @use HasFactory<LabFactory> */
    use HasFactory;

    public const NAMES = [
        'Lab Lingkungan',
        'Lab Kimia',
        'Lab Mikro',
        'Lab Udara',
        'Lab Proses dan Bahan Bangunan',
    ];

    protected $fillable = [
        'nama',
    ];

    public function komoditis(): HasMany
    {
        return $this->hasMany(Komoditi::class);
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }
}
