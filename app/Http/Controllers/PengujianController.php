<?php

namespace App\Http\Controllers;

use App\Models\AlurPengujian;
use App\Models\RuangLingkup;
use App\Models\Sertifikasi;
use Illuminate\View\View;

class PengujianController extends Controller
{
    /**
     * Display the Pengujian page with Certification and Scope tabs.
     */
    public function index(): View
    {
        $sertifikasi = Sertifikasi::first();
        $ruangLingkupan = RuangLingkup::all();
        $alurPengujian = AlurPengujian::first();

        return view('pengujian', compact('sertifikasi', 'ruangLingkupan', 'alurPengujian'));
    }
}
