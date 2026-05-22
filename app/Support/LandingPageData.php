<?php

namespace App\Support;

use App\Models\LogoMitra;
use App\Models\News;
use App\Models\SectionLayanan;
use App\Models\SectionProfil;
use App\Models\SectionSipintu;
use App\Models\SectionTestimoni;
use App\Models\SertifikatPerusahaan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingPageData
{
    private const PROFILE_FALLBACKS = [
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=1000',
        'https://images.unsplash.com/photo-1513828583688-c52646db42da?auto=format&fit=crop&q=80&w=700',
        'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=900',
    ];

    private const FAQ_FALLBACKS = [
        'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1581093450021-4a7360e9a6b5?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1563013544-824ae1b704d3?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1200&auto=format&fit=crop',
    ];

    private const SERVICE_ROUTES = [
        'pengujian' => 'pengujian.index',
        'kalibrasi' => 'kalibrasi.index',
        'kalibrasi-alat' => 'kalibrasi.index',
        'sertifikasi-produk' => 'sertifikasi-produk.index',
        'sertifikasi-halal' => 'lph.index',
        'lembaga-pemeriksa-halal' => 'lph.index',
        'industri-hijau' => 'lsih.index',
        'lsih' => 'lsih.index',
        'verifikasi-tkdn' => 'tkdn.index',
        'tkdn' => 'tkdn.index',
        'pelatihan-teknis' => 'pelatihan-teknis.index',
        'konsultasi-industri' => 'konsultasi-pendampingan.index',
        'konsultasi-pendampingan' => 'konsultasi-pendampingan.index',
    ];

    public function toArray(): array
    {
        return Cache::flexible('landing-page-data', [300, 600], fn (): array => $this->buildData());
    }

    /**
     * Build the full landing page data array (called on cache miss).
     */
    private function buildData(): array
    {
        $sectionProfils = $this->sectionProfils();
        $sectionSipintu = $this->sectionSipintu();
        $pelengkaps = $this->pelengkaps();
        $logoItems = $this->logoItems();
        $latestNews = $this->latestNews();
        $customerStats = $this->customerStats();
        $profileImages = $this->profileImages($sectionProfils);
        [$firstLogoGroup, $secondLogoGroup] = $this->logoGroups($logoItems);

        return [
            'profileImages' => $profileImages,
            'sejarahUrl' => $this->routeOrHash('sejarah-singkat.index'),
            'sipintuDesktopImage' => $this->sipintuDesktopImage($sectionSipintu),
            'sipintuMobileImage' => $this->sipintuMobileImage($sectionSipintu),
            'serviceItems' => $this->serviceItems(),
            'logoItems' => $logoItems,
            'firstLogoGroup' => $firstLogoGroup,
            'secondLogoGroup' => $secondLogoGroup,
            'showcaseImage' => $this->showcaseImage($pelengkaps),
            'certificateBgImage' => $profileImages->first() ?? self::PROFILE_FALLBACKS[0],
            'certificateItems' => $this->certificateItems(),
            'testimonialItems' => $this->testimonialItems(),
            'faqDisplayImages' => $this->faqDisplayImages($pelengkaps),
            'latestNewsItems' => $this->latestNewsItems($latestNews),
            'beritaIndexUrl' => $this->routeOrHash('berita.index'),
            'customerDistribution' => $customerStats['distribution'],
            'customerWithoutLocation' => $customerStats['without_location'],
        ];
    }

    private function sectionProfils(): Collection
    {
        return SectionProfil::query()
            ->select(['foto'])
            ->latest('id')
            ->limit(3)
            ->get();
    }

    private function sectionSipintu(): ?SectionSipintu
    {
        return SectionSipintu::query()
            ->select(['gambar_mobile', 'gambar_desktop'])
            ->first();
    }

    private function serviceItems(): Collection
    {
        return SectionLayanan::query()
            ->select(['gambar', 'nama_layanan', 'detail'])
            ->get()
            ->map(fn (SectionLayanan $layanan): array => [
                'name' => $layanan->nama_layanan,
                'detail' => $layanan->detail,
                'image_url' => $layanan->gambar ? Storage::url($layanan->gambar) : null,
                'url' => $this->serviceUrl($layanan->nama_layanan),
            ]);
    }

    private function logoItems(): Collection
    {
        return LogoMitra::query()
            ->where('tipe', LogoMitra::TYPE_LOGO)
            ->select(['gambar'])
            ->get()
            ->map(fn (LogoMitra $logo): array => [
                'image_url' => Storage::url($logo->gambar),
                'alt' => 'Logo Mitra',
            ]);
    }

    private function pelengkaps(): Collection
    {
        return LogoMitra::query()
            ->where('tipe', LogoMitra::TYPE_PELENGKAP)
            ->select(['gambar'])
            ->get();
    }

    private function certificateItems(): Collection
    {
        return SertifikatPerusahaan::query()
            ->select(['gambar', 'nama_sertifikat'])
            ->get()
            ->map(fn (SertifikatPerusahaan $sertifikat): array => [
                'image_url' => $sertifikat->gambar ? Storage::url($sertifikat->gambar) : null,
                'title' => $sertifikat->nama_sertifikat ?: 'Sertifikat',
            ])
            ->filter(fn (array $sertifikat): bool => filled($sertifikat['image_url']))
            ->values();
    }

    private function testimonialItems(): Collection
    {
        return SectionTestimoni::query()
            ->latest()
            ->get()
            ->map(fn (SectionTestimoni $testimoni): array => [
                'message' => $testimoni->pesan,
                'name' => $testimoni->nama,
                'company' => $testimoni->nama_perusahaan,
                'image_url' => $testimoni->gambar_pelanggan ? Storage::url($testimoni->gambar_pelanggan) : null,
                'initial' => Str::substr((string) $testimoni->nama, 0, 1),
            ]);
    }

    private function latestNews(): Collection
    {
        return News::query()
            ->published()
            ->select(['id', 'title', 'slug', 'excerpt', 'cover_image', 'published_at'])
            ->latest('published_at')
            ->limit(3)
            ->get();
    }

    private function latestNewsItems(Collection $latestNews): Collection
    {
        return $latestNews->map(fn (News $news): array => [
            'title' => $news->title,
            'excerpt' => $news->excerpt,
            'image_url' => $news->cover_image ? asset('storage/'.$news->cover_image) : asset('images/imagelab.webp'),
            'published_date' => $news->published_at?->format('d M Y'),
            'url' => route('berita.show', $news),
        ]);
    }

    private function profileImages(Collection $sectionProfils): Collection
    {
        return collect(range(0, 2))
            ->map(function (int $index) use ($sectionProfils): string {
                $item = $sectionProfils->get($index);

                return $item?->foto ? Storage::url($item->foto) : self::PROFILE_FALLBACKS[$index];
            });
    }

    private function sipintuDesktopImage(?SectionSipintu $sectionSipintu): string
    {
        return $sectionSipintu?->gambar_desktop
            ? Storage::url($sectionSipintu->gambar_desktop)
            : 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&q=80&w=1200';
    }

    private function sipintuMobileImage(?SectionSipintu $sectionSipintu): string
    {
        return $sectionSipintu?->gambar_mobile
            ? Storage::url($sectionSipintu->gambar_mobile)
            : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=800';
    }

    private function logoGroups(Collection $logoItems): array
    {
        $firstLogoGroupCount = (int) ceil(max(1, $logoItems->count()) / 2);
        $firstLogoGroup = $logoItems->slice(0, $firstLogoGroupCount)->values();
        $secondLogoGroup = $logoItems->slice($firstLogoGroupCount)->values();

        if ($secondLogoGroup->isEmpty()) {
            $secondLogoGroup = $firstLogoGroup;
        }

        return [$firstLogoGroup, $secondLogoGroup];
    }

    private function showcaseImage(Collection $pelengkaps): string
    {
        $firstPelengkap = $pelengkaps->first();

        return $firstPelengkap?->gambar
            ? Storage::url($firstPelengkap->gambar)
            : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1200&auto=format&fit=crop';
    }

    private function faqDisplayImages(Collection $pelengkaps): Collection
    {
        $faqImages = $pelengkaps
            ->take(4)
            ->map(fn (LogoMitra $pelengkap): string => Storage::url($pelengkap->gambar))
            ->values();

        return collect(range(0, 3))
            ->map(fn (int $index): string => $faqImages->get($index) ?? self::FAQ_FALLBACKS[$index]);
    }

    private function customerStats(): array
    {
        if (! Schema::hasTable('legacy_users') || ! Schema::hasTable('tbl_kabupaten') || ! Schema::hasTable('tbl_provinsi')) {
            return [
                'distribution' => collect(),
                'without_location' => 0,
            ];
        }

        $distribution = DB::table('legacy_users as users')
            ->join('tbl_kabupaten as kabupaten', 'kabupaten.kode_kabupaten', '=', 'users.kode_kabupaten')
            ->join('tbl_provinsi as provinsi', 'provinsi.kode_provinsi', '=', 'kabupaten.id_provinsi')
            ->whereNotNull('kabupaten.latitude')
            ->whereNotNull('kabupaten.longitude')
            ->whereNotNull('users.kode_kabupaten')
            ->where('users.kode_kabupaten', '!=', '')
            ->selectRaw('
                users.kode_kabupaten,
                kabupaten.nama_kabupaten,
                provinsi.nama_provinsi,
                kabupaten.latitude,
                kabupaten.longitude,
                COUNT(*) as total
            ')
            ->groupBy(
                'users.kode_kabupaten',
                'kabupaten.nama_kabupaten',
                'provinsi.nama_provinsi',
                'kabupaten.latitude',
                'kabupaten.longitude'
            )
            ->orderByDesc('total')
            ->get()
            ->map(fn (object $row): array => [
                'region' => "{$row->nama_kabupaten}, {$row->nama_provinsi}",
                'lat' => (float) $row->latitude,
                'lng' => (float) $row->longitude,
                'customers' => (int) $row->total,
            ]);

        $withoutLocation = DB::table('legacy_users as users')
            ->leftJoin('tbl_kabupaten as kabupaten', 'kabupaten.kode_kabupaten', '=', 'users.kode_kabupaten')
            ->where(function ($query): void {
                $query
                    ->whereNull('users.kode_kabupaten')
                    ->orWhere('users.kode_kabupaten', '')
                    ->orWhereNull('kabupaten.latitude')
                    ->orWhereNull('kabupaten.longitude');
            })
            ->count();

        return [
            'distribution' => $distribution,
            'without_location' => $withoutLocation,
        ];
    }

    private function serviceUrl(?string $serviceName): string
    {
        $routeName = self::SERVICE_ROUTES[Str::slug((string) $serviceName)] ?? null;

        return $routeName ? $this->routeOrHash($routeName) : '#';
    }

    private function routeOrHash(string $name): string
    {
        return Route::has($name) ? route($name) : '#';
    }
}
