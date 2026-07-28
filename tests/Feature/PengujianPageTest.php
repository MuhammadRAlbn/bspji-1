<?php

namespace Tests\Feature;

use App\Models\SpmPengujian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PengujianPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengujian_page_loads_successfully(): void
    {
        $this->get(route('pengujian.index'))
            ->assertOk();
    }

    public function test_page_contains_livewire_component(): void
    {
        $this->get(route('pengujian.index'))
            ->assertOk()
            ->assertSeeLivewire('tarif-pengujian');
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('pengujian.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Pengujian belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'pengujian/spm/'.Str::ulid().'.webp';

        SpmPengujian::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('pengujian.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Pengujian')
            ->assertDontSee('Gambar SPM Pengujian belum tersedia.');
    }
}
