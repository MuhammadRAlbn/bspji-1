<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UppSopFormulir extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'type',
        'path',
    ];
}
