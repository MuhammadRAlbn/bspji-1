<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiAlur;
use App\Models\KonsultasiRuangLingkup;
use Illuminate\View\View;

class KonsultasiPendampinganController extends Controller
{
    /**
     * Display the Konsultasi dan Pendampingan page.
     */
    public function index(): View
    {
        $ruangLingkupParagraf = KonsultasiRuangLingkup::where('type', 'paragraph')->first();
        $ruangLingkupImages = KonsultasiRuangLingkup::where('type', 'image')->get();
        $alur = KonsultasiAlur::all();

        return view('konsultasi-pendampingan', compact('ruangLingkupParagraf', 'ruangLingkupImages', 'alur'));
    }
}
