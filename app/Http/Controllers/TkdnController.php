<?php

namespace App\Http\Controllers;

use App\Models\SpmTkdn;
use App\Models\TkdnAlur;
use App\Models\TkdnRuangLingkup;
use Illuminate\View\View;

class TkdnController extends Controller
{
    /**
     * Display the Verifikasi TKDN page.
     */
    public function index(): View
    {
        $ruangLingkup = TkdnRuangLingkup::all();
        $alur = TkdnAlur::all();
        $spmTkdn = SpmTkdn::first();

        return view('tkdn', compact('ruangLingkup', 'alur', 'spmTkdn'));
    }
}
