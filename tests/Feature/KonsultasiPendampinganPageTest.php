<?php

namespace Tests\Feature;

use App\Models\SpmKonsultasiPendampingan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class KonsultasiPendampinganPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_konsultasi_pendampingan_page_loads_successfully(): void
    {
        $this->get(route('konsultasi-pendampingan.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('konsultasi-pendampingan.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Konsultansi dan Pendampingan belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'konsultasi-pendampingan/spm/'.Str::ulid().'.webp';

        SpmKonsultasiPendampingan::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('konsultasi-pendampingan.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Konsultansi dan Pendampingan')
            ->assertDontSee('Gambar SPM Konsultansi dan Pendampingan belum tersedia.');
    }
}
