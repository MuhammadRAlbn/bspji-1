<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ZonaIntegritasGrafikIkm extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'judul',
        'gambar',
        'urutan',
        'is_active',
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        'urutan' => 0,
        'is_active' => true,
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('judul');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
