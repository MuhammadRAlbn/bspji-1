<?php

namespace Tests\Feature;

use App\Models\SpmLsih;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LsihPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_lsih_page_loads_successfully(): void
    {
        $this->get(route('lsih.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('lsih.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Lembaga Sertifikasi Industri Hijau belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'lsih/spm/'.Str::ulid().'.webp';

        SpmLsih::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('lsih.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Lembaga Sertifikasi Industri Hijau')
            ->assertDontSee('Gambar SPM Lembaga Sertifikasi Industri Hijau belum tersedia.');
    }
}
