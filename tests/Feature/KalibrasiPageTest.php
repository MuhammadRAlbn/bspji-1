<?php

namespace Tests\Feature;

use App\Models\SpmKalibrasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class KalibrasiPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_kalibrasi_page_loads_successfully(): void
    {
        $this->get(route('kalibrasi.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('kalibrasi.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Kalibrasi belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'kalibrasi/spm/'.Str::ulid().'.webp';

        SpmKalibrasi::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('kalibrasi.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Kalibrasi')
            ->assertDontSee('Gambar SPM Kalibrasi belum tersedia.');
    }
}
