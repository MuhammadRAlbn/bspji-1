<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    protected $fillable = ['image', 'urutan'];

    protected $attributes = ['urutan' => 0];

    protected static function booted(): void
    {
        static::creating(function (Sertifikasi $sertifikasi): void {
            if ($sertifikasi->urutan === 0) {
                $sertifikasi->urutan = (int) static::query()->max('urutan') + 1;
            }
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('id');
    }

    protected function casts(): array
    {
        return ['urutan' => 'integer'];
    }
}
