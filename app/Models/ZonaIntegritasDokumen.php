<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZonaIntegritasDokumen extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'jenis_dokumen_id',
        'nama_dokumen',
        'file_path',
        'urutan',
        'is_active',
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        'urutan' => 0,
        'is_active' => true,
    ];

    public function jenisDokumen(): BelongsTo
    {
        return $this->belongsTo(ZonaIntegritasJenisDokumen::class, 'jenis_dokumen_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('nama_dokumen');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
