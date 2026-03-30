<?php

namespace App\Http\Controllers;

use App\Models\MottoVisiMisi;

class VisiMisiController extends Controller
{
    public function index()
    {
        $visiMisi = MottoVisiMisi::first();

        return view('visi-misi', compact('visiMisi'));
    }
}
