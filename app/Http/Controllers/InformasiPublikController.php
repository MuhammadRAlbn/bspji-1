<?php

namespace App\Http\Controllers;

use App\Models\DaftarInformasiPublik;
use App\Models\PermohonanInformasi;
use Illuminate\Contracts\View\View;

class InformasiPublikController extends Controller
{
    public function index(): View
    {
        $daftarInformasi = DaftarInformasiPublik::first();
        $permohonanInformasi = PermohonanInformasi::first();

        return view('informasi-publik', compact('daftarInformasi', 'permohonanInformasi'));
    }
}
