<?php

namespace App\Http\Controllers;

use App\Models\AlurKalibrasi;
use App\Models\RuangLingkupKalibrasi;
use App\Models\SertifikasiKalibrasi;
use Illuminate\View\View;

class KalibrasiController extends Controller
{
    /**
     * Display the Kalibrasi page with Certification and Scope tabs.
     */
    public function index(): View
    {
        $sertifikasis = SertifikasiKalibrasi::all();
        $ruangLingkupan = RuangLingkupKalibrasi::all();
        $alurKalibrasi = AlurKalibrasi::first();

        return view('kalibrasi', compact('sertifikasis', 'ruangLingkupan', 'alurKalibrasi'));
    }
}
