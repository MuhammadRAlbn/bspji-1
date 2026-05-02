<?php

namespace App\Models;

use Database\Factories\KomoditiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komoditi extends Model
{
    /** @use HasFactory<KomoditiFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'peraturan',
        'lab_id',
        'keterangan',
    ];

    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }
}
