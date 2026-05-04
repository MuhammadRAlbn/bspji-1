<?php

namespace App\Http\Controllers;

use App\Models\MottoVisiMisi;
use App\Models\ProfilPejabat;
use App\Models\SectionProfil;
use App\Models\SejarahSingkat;
use App\Models\StrukturOrganisasi;
use App\Models\TugasFungsi;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index(string $activeTab = 'sejarah')
    {
        $tabs = collect([
            'sejarah' => [
                'label' => 'Sejarah',
                'route' => 'sejarah-singkat.index',
            ],
            'motto' => [
                'label' => 'Moto',
                'route' => 'visi-misi.index',
            ],
            'tugas' => [
                'label' => 'Tugas',
                'route' => 'tugas-fungsi.index',
            ],
            'struktur' => [
                'label' => 'Struktur',
                'route' => 'struktur-organisasi.index',
            ],
            'profil' => [
                'label' => 'Profil',
                'route' => 'profil-pejabat.index',
            ],
        ]);

        if (! $tabs->has($activeTab)) {
            $activeTab = 'sejarah';
        }

        $heroImage = SectionProfil::query()
            ->whereNotNull('foto')
            ->latest('id')
            ->value('foto');

        return view('profil', [
            'activeTab' => $activeTab,
            'tabs' => $tabs,
            'heroImage' => $heroImage
                ? Storage::url($heroImage)
                : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1600&auto=format&fit=crop',
            'sejarahSingkats' => SejarahSingkat::query()
                ->select(['id', 'tahun', 'judul', 'detail', 'gambar'])
                ->orderByDesc('tahun')
                ->get(),
            'visiMisi' => MottoVisiMisi::query()->first(),
            'tugasFungsi' => TugasFungsi::query()->first(),
            'strukturOrganisasi' => StrukturOrganisasi::query()->first(),
            'pejabats' => ProfilPejabat::query()
                ->select(['id', 'foto', 'nama', 'jabatan', 'detail'])
                ->orderBy('id')
                ->get(),
        ]);
    }
}
