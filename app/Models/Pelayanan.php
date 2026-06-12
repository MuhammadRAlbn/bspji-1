<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    /** @var string */
    protected $table = 'pelayanan';

    /** @var array<int, string> */
    protected $fillable = [
        'tingkat_pelayanan',
        'petugas_upp',
    ];

    /**
     * Tabel hanya memiliki kolom `created_at` tanpa `updated_at`.
     */
    public const UPDATED_AT = null;
}
