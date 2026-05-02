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
        $ruangLingkupan = RuangLingkup::query()
            ->orderedByLab()
            ->get();
        $alurPengujian = AlurPengujian::first();
        $labOptions = RuangLingkup::labOptions();

        return view('pengujian', compact('sertifikasi', 'ruangLingkupan', 'alurPengujian', 'labOptions'));
    }
}
