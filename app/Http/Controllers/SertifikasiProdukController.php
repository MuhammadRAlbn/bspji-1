<?php

namespace App\Http\Controllers;

use App\Models\AlurProduk;
use App\Models\RuangLingkupProduk;
use App\Models\SertifikatProduk;
use Illuminate\View\View;

class SertifikasiProdukController extends Controller
{
    /**
     * Display the Sertifikasi Produk page with tabs for Certificate, Scope, and Flow.
     */
    public function index(): View
    {
        $sertifikats = SertifikatProduk::all();
        $ruangLingkup = RuangLingkupProduk::all();
        $alurProduk = AlurProduk::first();

        return view('sertifikasi-produk', compact('sertifikats', 'ruangLingkup', 'alurProduk'));
    }
}
