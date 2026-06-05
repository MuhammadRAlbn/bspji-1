<?php

namespace App\Http\Controllers;

use App\Models\AlurProduk;
use App\Models\DirektoriPelanggan;
use App\Models\DokumenProduk;
use App\Models\HakKewajibanProduk;
use App\Models\InformasiPublikProduk;
use App\Models\RuangLingkupProduk;
use App\Models\SdmSertifikasiProduk;
use App\Models\SertifikatProduk;
use App\Models\TarifProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SertifikasiProdukController extends Controller
{
    /**
     * Display the Sertifikasi Produk page with tabs for Certificate, Scope, and Flow.
     */
    public function index(Request $request): View
    {
        $direktoriSearch = $request->string('direktori_search')->trim()->toString();
        $activeTab = (
            $request->query('tab') === 'direktori-pelanggan'
            || $request->has('direktori_search')
            || $request->has('direktori_page')
        ) ? 'direktori-pelanggan' : 'sertifikat';

        $sertifikats = SertifikatProduk::all();
        $ruangLingkup = RuangLingkupProduk::all();
        $alurProduk = AlurProduk::first();
        $dokumens = DokumenProduk::all();
        $informasiPubliks = InformasiPublikProduk::all();
        $tarifs = TarifProduk::all();
        $hakKewajibans = HakKewajibanProduk::all();
        $direktoriPelanggan = DirektoriPelanggan::query()
            ->select(['id', 'nama_perusahaan', 'merek', 'tahun_sertifikasi', 'gambar', 'alamat', 'is_active'])
            ->when($direktoriSearch !== '', function ($query) use ($direktoriSearch): void {
                $query->where(function ($query) use ($direktoriSearch): void {
                    $query
                        ->where('nama_perusahaan', 'like', "%{$direktoriSearch}%")
                        ->orWhere('merek', 'like', "%{$direktoriSearch}%")
                        ->orWhere('tahun_sertifikasi', 'like', "%{$direktoriSearch}%")
                        ->orWhere('alamat', 'like', "%{$direktoriSearch}%");
                });
            })
            ->orderBy('id')
            ->paginate(10, ['*'], 'direktori_page')
            ->withQueryString();
        $countAhliMadya = SdmSertifikasiProduk::where('kategori', 'ahli_madya')->count();
        $countAhliMuda = SdmSertifikasiProduk::where('kategori', 'ahli_muda')->count();
        $countAhliPertama = SdmSertifikasiProduk::where('kategori', 'ahli_pertama')->count();

        return view('sertifikasi-produk', compact(
            'sertifikats',
            'ruangLingkup',
            'alurProduk',
            'dokumens',
            'informasiPubliks',
            'tarifs',
            'hakKewajibans',
            'direktoriPelanggan',
            'direktoriSearch',
            'activeTab',
            'countAhliMadya',
            'countAhliMuda',
            'countAhliPertama'
        ));
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

    /**
     * Download an informasi publik file.
     */
    public function downloadInformasi(InformasiPublikProduk $informasi): BinaryFileResponse
    {
        $path = Storage::disk('public')->path($informasi->file_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $informasi->nama.'.'.$extension;

        return response()->download($path, $filename);
    }

    /**
     * Download a hak dan kewajiban document.
     */
    public function downloadHakKewajiban(HakKewajibanProduk $hakKewajiban): BinaryFileResponse
    {
        $path = Storage::disk('public')->path($hakKewajiban->file_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $hakKewajiban->nama_dokumen.'.'.$extension;

        return response()->download($path, $filename);
    }
}
