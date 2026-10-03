<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ZonaIntegritasPengaduanDownloadAccessTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('downloadRoles')]
    public function test_bukti_download_checks_role_and_active_status(string $role, bool $active, int $status): void
    {
        $record = $this->document();
        $this->actingAs(User::factory()->create(['role' => $role, 'is_active' => $active]));
        $response = $this->get(route('zona-integritas.pengaduan.bukti.download', $record))->assertStatus($status);
        if ($status === 200) {
            $response->assertDownload('bukti.pdf');
        }
    }

    public function test_guest_is_redirected_to_panel_login_for_bukti(): void
    {
        $this->get(route('zona-integritas.pengaduan.bukti.download', $this->document()))
            ->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_missing_bukti_returns_404_to_an_authorized_reader(): void
    {
        $record = $this->document();
        Storage::disk('local')->delete($record->bukti_dukung_path);
        $this->actingAs(User::factory()->create(['role' => 'kepala_balai']));
        $this->get(route('zona-integritas.pengaduan.bukti.download', $record))->assertNotFound();
    }

    public function test_result_document_keeps_its_existing_public_download_behavior(): void
    {
        $record = $this->document();
        $this->get(route('zona-integritas.pengaduan.hasil.download', $record->nomor_pengaduan))
            ->assertOk()->assertDownload('hasil.pdf');
    }

    public static function downloadRoles(): array
    {
        return [['admin', true, 200], ['fap', true, 200], ['kepala_balai', true, 200], ['humas', true, 403], ['viewer', true, 403], ['fap', false, 403], ['admin', false, 403]];
    }

    private function document(): ZonaIntegritasPengaduan
    {
        Storage::fake('local');
        Storage::disk('local')->put('bukti.pdf', '%PDF-1.4');
        Storage::disk('local')->put('hasil.pdf', '%PDF-1.4');

        return ZonaIntegritasPengaduan::create([
            'nomor_pengaduan' => '20260500001', 'tahun_pengaduan' => 2026, 'sequence' => 500001,
            'nama' => 'Pelapor', 'jenis_pengaduan' => 'pengaduan', 'judul' => 'Laporan', 'uraian' => 'Uraian laporan lengkap.',
            'bukti_dukung_path' => 'bukti.pdf', 'bukti_dukung_nama' => 'bukti.pdf', 'dokumen_hasil_path' => 'hasil.pdf', 'dokumen_hasil_nama' => 'hasil.pdf',
        ]);
    }
}
