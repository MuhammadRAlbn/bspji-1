<?php

namespace Tests\Feature;

use App\Models\SpmSertifikasiProduk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SertifikasiProdukPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_sertifikasi_produk_page_loads_successfully(): void
    {
        $this->get(route('sertifikasi-produk.index'))
            ->assertOk();
    }

    public function test_page_contains_spm_tab_and_empty_placeholder(): void
    {
        $this->get(route('sertifikasi-produk.index'))
            ->assertOk()
            ->assertSee('SPM')
            ->assertSee('Gambar SPM Sertifikasi Produk belum tersedia.');
    }

    public function test_page_displays_spm_image_and_lightbox_content(): void
    {
        $path = 'sertifikasi-produk/spm/'.Str::ulid().'.webp';

        SpmSertifikasiProduk::query()->create([
            'image_path' => $path,
        ]);

        $this->get(route('sertifikasi-produk.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$path))
            ->assertSee('Standar Pelayanan Minimal (SPM) Sertifikasi Produk')
            ->assertDontSee('Gambar SPM Sertifikasi Produk belum tersedia.');
    }
}
