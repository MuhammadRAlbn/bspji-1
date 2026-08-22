<?php

namespace App\Support;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class SitemapUrlProvider
{
    public const CACHE_KEY = 'seo:sitemap:v1';

    private const CACHE_TTL_SECONDS = 3600;

    private const STATIC_ROUTE_NAMES = [
        'home',
        'zona-integritas.index',
        'sejarah-singkat.index',
        'pengujian.index',
        'kalibrasi.index',
        'sertifikasi-produk.index',
        'lph.index',
        'lsih.index',
        'tkdn.index',
        'pelatihan-teknis.index',
        'konsultasi-pendampingan.index',
        'upp.index',
        'ppid.index',
        'informasi-publik.index',
        'berita.index',
        'hubungi-kami.index',
    ];

    private const INFORMATION_TYPES = [
        'berkala',
        'setiap_saat',
        'serta_merta',
        'dikecualikan',
    ];

    public function urls(): array
    {
        return Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL_SECONDS,
            fn (): array => $this->buildUrls(),
        );
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function buildUrls(): array
    {
        $staticUrls = collect(self::STATIC_ROUTE_NAMES)
            ->map(fn (string $routeName): array => [
                'loc' => $this->absoluteRoute($routeName),
            ]);

        $informationUrls = collect(self::INFORMATION_TYPES)
            ->map(fn (string $type): array => [
                'loc' => $this->absoluteRoute('detail-informasi.show', ['tipe' => $type]),
            ]);

        $newsUrls = News::query()
            ->published()
            ->select(['id', 'slug', 'updated_at'])
            ->orderBy('id')
            ->get()
            ->map(fn (News $news): array => [
                'loc' => $this->absoluteRoute('berita.show', ['news' => $news->slug]),
                'lastmod' => $news->updated_at->toAtomString(),
            ]);

        return $staticUrls
            ->concat($informationUrls)
            ->concat($newsUrls)
            ->unique('loc')
            ->values()
            ->all();
    }

    private function absoluteRoute(string $routeName, array $parameters = []): string
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $path = ltrim(route($routeName, $parameters, false), '/');

        return $path === '' ? $baseUrl : $baseUrl.'/'.$path;
    }
}
