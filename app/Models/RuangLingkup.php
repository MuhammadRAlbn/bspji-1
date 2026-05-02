<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class RuangLingkup extends Model
{
    use HasFactory;

    protected static ?bool $hasLabColumn = null;

    public const LAB_LINGKUNGAN = 'lab_lingkungan';

    public const LAB_KIMIA = 'lab_kimia';

    public const LAB_MIKRO = 'lab_mikro';

    public const LAB_UDARA = 'lab_udara';

    public const LAB_PROSES_DAN_BAHAN_BANGUNAN = 'lab_proses_dan_bahan_bangunan';

    public const LAB_OPTIONS = [
        self::LAB_LINGKUNGAN => 'Lab Lingkungan',
        self::LAB_KIMIA => 'Lab Kimia',
        self::LAB_MIKRO => 'Lab Mikro',
        self::LAB_UDARA => 'Lab Udara',
        self::LAB_PROSES_DAN_BAHAN_BANGUNAN => 'Lab Proses dan Bahan Bangunan',
    ];

    protected $fillable = [
        'lab',
        'komoditi',
        'ruang_lingkup',
    ];

    public static function labOptions(): array
    {
        return self::LAB_OPTIONS;
    }

    public static function getLabLabel(?string $lab): string
    {
        return self::LAB_OPTIONS[$lab] ?? 'Lab belum dipilih';
    }

    public static function hasLabColumn(): bool
    {
        return static::$hasLabColumn ??= Schema::hasColumn((new static)->getTable(), 'lab');
    }

    public function scopeOrderedByLab(Builder $query): Builder
    {
        $table = $query->getModel()->getTable();

        if (! static::hasLabColumn()) {
            return $query->orderBy("{$table}.komoditi");
        }

        return $query
            ->orderByRaw(
                "CASE {$table}.lab
                    WHEN ? THEN 1
                    WHEN ? THEN 2
                    WHEN ? THEN 3
                    WHEN ? THEN 4
                    WHEN ? THEN 5
                    ELSE 99
                END",
                array_keys(self::LAB_OPTIONS),
            )
            ->orderBy("{$table}.komoditi");
    }
}
