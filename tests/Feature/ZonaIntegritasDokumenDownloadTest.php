<?php

namespace Tests\Feature;

use App\Models\ZonaIntegritasDokumen;
use App\Models\ZonaIntegritasJenisDokumen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ZonaIntegritasDokumenDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_document_can_be_downloaded(): void
    {
        Storage::fake('public');

        $dokumen = $this->createDokumen([
            'nama_dokumen' => 'Pedoman Zona Integritas',
            'file_path' => 'zona-integritas/dokumen/pedoman.pdf',
        ]);

        Storage::disk('public')->put($dokumen->file_path, '%PDF-1.4');

        $this->get(route('zona-integritas.dokumen.download', $dokumen))
            ->assertOk()
            ->assertDownload('pedoman-zona-integritas.pdf');
    }

    public function test_missing_document_file_returns_not_found(): void
    {
        Storage::fake('public');

        $dokumen = $this->createDokumen([
            'file_path' => 'zona-integritas/dokumen/missing.pdf',
        ]);

        $this->get(route('zona-integritas.dokumen.download', $dokumen))
            ->assertNotFound();
    }

    public function test_inactive_document_returns_not_found(): void
    {
        Storage::fake('public');

        $dokumen = $this->createDokumen([
            'file_path' => 'zona-integritas/dokumen/inactive.pdf',
            'is_active' => false,
        ]);

        Storage::disk('public')->put($dokumen->file_path, '%PDF-1.4');

        $this->get(route('zona-integritas.dokumen.download', $dokumen))
            ->assertNotFound();
    }

    private function createDokumen(array $attributes = []): ZonaIntegritasDokumen
    {
        $jenisDokumen = ZonaIntegritasJenisDokumen::query()
            ->where('kode', ZonaIntegritasJenisDokumen::KODE_ZONA_INTEGRITAS)
            ->firstOrFail();

        return ZonaIntegritasDokumen::query()->create([
            'jenis_dokumen_id' => $jenisDokumen->id,
            'nama_dokumen' => 'Dokumen Zona Integritas',
            'file_path' => 'zona-integritas/dokumen/dokumen.pdf',
            'urutan' => 0,
            'is_active' => true,
            ...$attributes,
        ]);
    }
}
