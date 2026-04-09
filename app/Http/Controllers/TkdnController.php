<?php

namespace App\Http\Controllers;

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

        return view('tkdn', compact('ruangLingkup', 'alur'));
    }
}
