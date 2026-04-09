<?php

namespace App\Http\Controllers;

use App\Models\ProfilUpp;
use App\Models\UppVisiMisi;
use App\Models\UppMaklumatPelayanan;
use App\Models\UppSopFormulir;
use Illuminate\View\View;

class UppController extends Controller
{
    /**
     * Display the Unit Pelayanan Publik (UPP) page.
     */
    public function index(): View
    {
        $profil = ProfilUpp::first();
        $visiMisi = UppVisiMisi::first();
        $maklumat = UppMaklumatPelayanan::first();
        $sopFormulir = UppSopFormulir::all()->groupBy('type');

        return view('upp', compact('profil', 'visiMisi', 'maklumat', 'sopFormulir'));
    }
}
