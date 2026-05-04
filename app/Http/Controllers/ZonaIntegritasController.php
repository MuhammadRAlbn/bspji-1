<?php

namespace App\Http\Controllers;

use App\Models\ZonaIntegritasDokumen;
use App\Models\ZonaIntegritasGrafikIkm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZonaIntegritasController extends Controller
{
    public function index(Request $request): View
    {
        $validTabs = [
            'zona-integritas',
            'ikm',
            'ipk',
            'pengaduan',
            'benturan',
            'gratifikasi',
            'wbs',
        ];

        $initialActive = in_array($request->query('tab'), $validTabs, true)
            ? $request->query('tab')
            : 'zona-integritas';

        $zonaIntegritasDokumens = ZonaIntegritasDokumen::query()
            ->select(['id', 'jenis_dokumen_id', 'nama_dokumen', 'file_path', 'urutan', 'is_active'])
            ->active()
            ->ordered()
            ->with(['jenisDokumen:id,kode,nama'])
            ->get()
            ->groupBy(fn (ZonaIntegritasDokumen $dokumen): string => $dokumen->jenisDokumen->kode);

        $zonaIntegritasGrafikIkms = ZonaIntegritasGrafikIkm::query()
            ->select(['id', 'judul', 'gambar', 'urutan', 'is_active'])
            ->active()
            ->ordered()
            ->get();

        return view('zona-integritas', compact(
            'initialActive',
            'zonaIntegritasDokumens',
            'zonaIntegritasGrafikIkms'
        ));
    }
}
