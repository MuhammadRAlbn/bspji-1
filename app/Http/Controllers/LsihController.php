<?php

namespace App\Http\Controllers;

use App\Models\LsihAlur;
use App\Models\LsihRuangLingkup;
use App\Models\LsihTarif;
use Illuminate\View\View;

class LsihController extends Controller
{
    /**
     * Display the Laboratorium Sentral Ilmu Hayati (LSIH) page.
     */
    public function index(): View
    {
        $ruangLingkup = LsihRuangLingkup::all();
        $alur = LsihAlur::all();
        $tarif = LsihTarif::all();

        return view('lsih', compact('ruangLingkup', 'alur', 'tarif'));
    }
}
