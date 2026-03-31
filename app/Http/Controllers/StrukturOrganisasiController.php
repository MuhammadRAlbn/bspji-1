<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $strukturOrganisasi = StrukturOrganisasi::first();

        return view('struktur-organisasi', compact('strukturOrganisasi'));
    }
}
