<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblNps extends Model
{
    /** @var string */
    protected $table = 'tbl_nps';

    /** @var array<int, string> */
    protected $fillable = [
        'nps',
    ];

    /**
     * Tabel hanya memiliki kolom `created_at` tanpa `updated_at`.
     */
    public const UPDATED_AT = null;
}
