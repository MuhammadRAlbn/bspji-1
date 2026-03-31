<?php

namespace App\Http\Controllers;

use App\Models\ProfilPejabat;

class ProfilPejabatController extends Controller
{
    public function index()
    {
        $pejabats = ProfilPejabat::all();

        return view('profil-pejabat', compact('pejabats'));
    }
}
