<?php

namespace App\Http\Controllers;

use App\Models\AlurProduk;
use App\Models\DokumenProduk;
use App\Models\RuangLingkupProduk;
use App\Models\SertifikatProduk;
use App\Models\TarifProduk;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $dokumens = DokumenProduk::all();
        $tarifs = TarifProduk::all();

        return view('sertifikasi-produk', compact('sertifikats', 'ruangLingkup', 'alurProduk', 'dokumens', 'tarifs'));
    }

    /**
     * Download a product document with its original or formatted name.
     */
    public function download(DokumenProduk $dokumenProduk): BinaryFileResponse
    {
        $path = Storage::disk('public')->path($dokumenProduk->file_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $dokumenProduk->nama_dokumen.'.'.$extension;

        return response()->download($path, $filename);
    }
}
