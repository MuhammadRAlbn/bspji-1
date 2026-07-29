<?php

namespace Tests\Feature;

use App\Models\SpmLph;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LphPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_lph_page_loads_successfully(): void
    {
        $this->get(route('lph.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('lph.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Lembaga Pemeriksa Halal belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'lph/spm/'.Str::ulid().'.webp';

        SpmLph::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('lph.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Lembaga Pemeriksa Halal')
            ->assertDontSee('Gambar SPM Lembaga Pemeriksa Halal belum tersedia.');
    }
}
