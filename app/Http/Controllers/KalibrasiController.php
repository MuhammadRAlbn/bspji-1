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
        $sertifikasi = SertifikasiKalibrasi::first();
        $ruangLingkupan = RuangLingkupKalibrasi::all();
        $alurKalibrasi = AlurKalibrasi::first();

        return view('kalibrasi', compact('sertifikasi', 'ruangLingkupan', 'alurKalibrasi'));
    }
}
