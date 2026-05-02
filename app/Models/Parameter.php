<?php

namespace App\Models;

use Database\Factories\ParameterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parameter extends Model
{
    /** @use HasFactory<ParameterFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'metode_uji',
        'satuan',
        'baku_mutu',
        'lab_id',
        'komoditi_id',
        'harga',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
        ];
    }

    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    public function komoditi(): BelongsTo
    {
        return $this->belongsTo(Komoditi::class);
    }
}
