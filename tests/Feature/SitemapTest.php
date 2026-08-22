<?php

namespace Tests\Feature;

use App\Models\News;
use App\Support\SitemapUrlProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = 'https://bspjiaceh.kemenperin.go.id';

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => self::BASE_URL]);
        SitemapUrlProvider::clearCache();
    }

    public function test_sitemap_contains_only_canonical_public_static_urls(): void
    {
        $response = $this->withServerVariables([
            'HTTP_HOST' => 'www.example.test',
            'SERVER_NAME' => 'www.example.test',
            'HTTPS' => 'off',
        ])->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $locations = $this->locations($response->getContent());

        foreach ($this->expectedStaticUrls() as $expectedUrl) {
            $this->assertContains($expectedUrl, $locations);
        }

        $this->assertNotContains(self::BASE_URL.'/visi-misi', $locations);
        $this->assertNotContains(self::BASE_URL.'/tugas-fungsi', $locations);
        $this->assertNotContains(self::BASE_URL.'/struktur-organisasi', $locations);
        $this->assertNotContains(self::BASE_URL.'/profil-pejabat', $locations);
        $this->assertCount(count($this->expectedStaticUrls()), $locations);
        $this->assertCount(count(array_unique($locations)), $locations);

        foreach ($locations as $location) {
            $this->assertStringStartsWith(self::BASE_URL, $location);
            $this->assertStringNotContainsString('?', $location);
            $this->assertStringNotContainsString('/admin', $location);
            $this->assertStringNotContainsString('/api', $location);
            $this->assertStringNotContainsString('/download', $location);
            $this->assertNotSame(self::BASE_URL.'/up', $location);
        }
    }

    public function test_robots_txt_references_the_canonical_sitemap(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));

        $this->assertNotFalse($robots);
        $this->assertStringContainsString(
            'Sitemap: '.self::BASE_URL.'/sitemap.xml',
            $robots,
        );
    }

    public function test_sitemap_contains_only_published_news_with_accurate_lastmod(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-08-22 09:00:00', 'UTC'));

        $published = News::factory()->published()->create([
            'slug' => 'berita-publik-sitemap',
        ]);
        $draft = News::factory()->create([
            'slug' => 'berita-draft-sitemap',
        ]);
        $future = News::factory()->create([
            'slug' => 'berita-masa-depan-sitemap',
            'status' => News::STATUS_PUBLISHED,
            'published_at' => now()->addDay(),
        ]);

        $response = $this->get(route('sitemap'))
            ->assertOk();

        $locations = $this->locations($response->getContent());

        $this->assertContains(self::BASE_URL.'/berita/'.$published->slug, $locations);
        $this->assertNotContains(self::BASE_URL.'/berita/'.$draft->slug, $locations);
        $this->assertNotContains(self::BASE_URL.'/berita/'.$future->slug, $locations);
        $response->assertSee('<lastmod>'.$published->updated_at->toAtomString().'</lastmod>', false);

        Carbon::setTestNow();
    }

    public function test_sitemap_cache_is_invalidated_when_news_visibility_changes(): void
    {
        $newsUrl = self::BASE_URL.'/berita/berita-cache-sitemap';

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertDontSee($newsUrl);

        $news = News::factory()->published()->create([
            'slug' => 'berita-cache-sitemap',
        ]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertSee($newsUrl);

        $news->update([
            'status' => News::STATUS_DRAFT,
            'published_at' => null,
        ]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertDontSee($newsUrl);
    }

    private function locations(string $content): array
    {
        $xml = simplexml_load_string($content);

        $this->assertNotFalse($xml, 'Sitemap harus berupa XML yang valid.');

        $xml->registerXPathNamespace('sitemap', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        return array_map(
            static fn ($location): string => (string) $location,
            $xml->xpath('//sitemap:loc'),
        );
    }

    private function expectedStaticUrls(): array
    {
        return [
            self::BASE_URL,
            self::BASE_URL.'/zona-integritas',
            self::BASE_URL.'/sejarah-singkat',
            self::BASE_URL.'/pengujian',
            self::BASE_URL.'/kalibrasi',
            self::BASE_URL.'/sertifikasi-produk',
            self::BASE_URL.'/lembaga-pemeriksa-halal',
            self::BASE_URL.'/lsih',
            self::BASE_URL.'/verifikasi-tkdn',
            self::BASE_URL.'/pelatihan-teknis',
            self::BASE_URL.'/konsultasi-pendampingan',
            self::BASE_URL.'/upp',
            self::BASE_URL.'/ppid',
            self::BASE_URL.'/informasi-publik',
            self::BASE_URL.'/informasi-publik/detail/berkala',
            self::BASE_URL.'/informasi-publik/detail/setiap_saat',
            self::BASE_URL.'/informasi-publik/detail/serta_merta',
            self::BASE_URL.'/informasi-publik/detail/dikecualikan',
            self::BASE_URL.'/berita',
            self::BASE_URL.'/hubungi-kami',
        ];
    }
}
