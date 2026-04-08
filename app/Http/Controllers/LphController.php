<?php

namespace App\Http\Controllers;

use App\Models\LphAlurDanKelengkapan;
use App\Models\LphStrukturVisiMisi;
use App\Models\RuangLingkupLph;
use App\Models\SdmLph;
use Illuminate\View\View;

class LphController extends Controller
{
    /**
     * Display the Lembaga Pemeriksa Halal page.
     */
    public function index(): View
    {
        $ruangLingkup = RuangLingkupLph::all();
        $sdmAuditor = SdmLph::where('kategori', 'Auditor Halal')->get();
        $sdmPembina = SdmLph::where('kategori', 'Dewan Pembina Syariah')->get();
        $alurKelengkapan = LphAlurDanKelengkapan::orderBy('urutan')->get();
        $strukturVisiMisi = LphStrukturVisiMisi::orderBy('urutan')->get();

        return view('lph', compact('ruangLingkup', 'sdmAuditor', 'sdmPembina', 'alurKelengkapan', 'strukturVisiMisi'));
    }
}
