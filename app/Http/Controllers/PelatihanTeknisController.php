<?php

namespace App\Http\Controllers;

use App\Models\PelatihanTeknisAlur;
use App\Models\PelatihanTeknisRuangLingkup;
use App\Models\SpmPelatihanTeknis;
use Illuminate\View\View;

class PelatihanTeknisController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function index(): View
    {
        $ruangLingkup = PelatihanTeknisRuangLingkup::first();
        $alur = PelatihanTeknisAlur::first();
        $spmPelatihanTeknis = SpmPelatihanTeknis::first();

        return view('pelatihan-teknis', [
            'ruangLingkup' => $ruangLingkup,
            'alur' => $alur,
            'spmPelatihanTeknis' => $spmPelatihanTeknis,
        ]);
    }
}
