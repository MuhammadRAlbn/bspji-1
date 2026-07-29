<?php

namespace Tests\Feature;

use App\Models\SpmPelatihanTeknis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PelatihanTeknisPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelatihan_teknis_page_loads_successfully(): void
    {
        $this->get(route('pelatihan-teknis.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('pelatihan-teknis.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Pelatihan Teknis belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'pelatihan-teknis/spm/'.Str::ulid().'.webp';

        SpmPelatihanTeknis::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('pelatihan-teknis.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Pelatihan Teknis')
            ->assertDontSee('Gambar SPM Pelatihan Teknis belum tersedia.');
    }
}
