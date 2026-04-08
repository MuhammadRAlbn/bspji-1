<?php

namespace App\Http\Controllers;

use App\Models\TugasFungsi;

class TugasFungsiController extends Controller
{
    public function index()
    {
        $tugasFungsi = TugasFungsi::first();

        return view('tugas-fungsi', compact('tugasFungsi'));
    }
}
