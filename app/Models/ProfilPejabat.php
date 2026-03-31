<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPejabat extends Model
{
    protected $fillable = [
        'foto',
        'nama',
        'jabatan',
        'detail',
    ];
}
