<?php

namespace Tests\Feature;

use App\Models\SpmTkdn;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TkdnPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_tkdn_page_loads_successfully(): void
    {
        $this->get(route('tkdn.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('tkdn.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Verifikasi TKDN belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'verifikasi-tkdn/spm/'.Str::ulid().'.webp';

        SpmTkdn::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('tkdn.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Verifikasi TKDN')
            ->assertDontSee('Gambar SPM Verifikasi TKDN belum tersedia.');
    }
}
