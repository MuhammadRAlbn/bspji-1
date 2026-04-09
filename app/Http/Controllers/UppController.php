<?php

namespace App\Http\Controllers;

use App\Models\ProfilUpp;
use Illuminate\View\View;

class UppController extends Controller
{
    /**
     * Display the Unit Pelayanan Publik (UPP) page.
     */
    public function index(): View
    {
        $profil = ProfilUpp::first();

        return view('upp', compact('profil'));
    }
}
