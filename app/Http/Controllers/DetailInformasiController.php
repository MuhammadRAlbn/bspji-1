<?php

namespace App\Http\Controllers;

use App\Models\DetailInformasi;
use Illuminate\Contracts\View\View;

class DetailInformasiController extends Controller
{
    public function show(string $tipe): View
    {
        $validTipes = ['berkala', 'setiap_saat', 'serta_merta', 'dikecualikan'];
        abort_unless(in_array($tipe, $validTipes), 404);

        $dokumen = in_array($tipe, ['berkala', 'setiap_saat'])
            ? DetailInformasi::where('tipe', $tipe)
                ->orderBy('kategori_id')
                ->orderBy('urutan')
                ->get()
                ->groupBy('kategori_id')
            : collect();

        $tipeLabels = [
            'berkala' => 'Informasi Berkala',
            'setiap_saat' => 'Informasi Setiap Saat',
            'serta_merta' => 'Informasi Serta Merta',
            'dikecualikan' => 'Informasi Dikecualikan',
        ];

        $tipeOrder = ['berkala', 'setiap_saat', 'serta_merta', 'dikecualikan'];
        $currentIndex = array_search($tipe, $tipeOrder);
        $prevTipe = $currentIndex > 0 ? $tipeOrder[$currentIndex - 1] : null;
        $nextTipe = $currentIndex < count($tipeOrder) - 1 ? $tipeOrder[$currentIndex + 1] : null;

        $kategoriLabels = match ($tipe) {
            'berkala' => DetailInformasi::KATEGORI_BERKALA,
            'setiap_saat' => DetailInformasi::KATEGORI_SETIAP_SAAT,
            default => [],
        };

        return view('detail-informasi', compact(
            'tipe',
            'dokumen',
            'tipeLabels',
            'prevTipe',
            'nextTipe',
            'kategoriLabels',
        ));
    }
}
