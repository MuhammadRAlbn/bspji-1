<?php

namespace Tests\Feature;

use App\Http\Controllers\ZonaIntegritasController;
use App\Models\ZonaIntegritasPengaduan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ZonaIntegritasPengaduanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengaduan_submission_creates_first_number_and_default_status(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-05-22 09:00:00', 'Asia/Jakarta'));
        Storage::fake('local');

        $this->post(route('zona-integritas.pengaduan.store'), $this->validPayload())
            ->assertRedirect(route('zona-integritas.index', ['tab' => 'pengaduan']))
            ->assertSessionHas('pengaduan_success_nomor', '20260500001');

        $this->assertDatabaseHas('zona_integritas_pengaduans', [
            'nomor_pengaduan' => '20260500001',
            'sequence' => 500001,
            'tahun_pengaduan' => 2026,
            'status' => ZonaIntegritasPengaduan::STATUS_DITERIMA,
        ]);

        Carbon::setTestNow();
    }

    public function test_pengaduan_number_keeps_global_sequence_across_years(): void
    {
        Carbon::setTestNow(Carbon::parse('2027-01-02 09:00:00', 'Asia/Jakarta'));

        DB::table('zona_integritas_pengaduan_sequences')
            ->where('id', 1)
            ->update(['last_sequence' => 500011]);

        $this->post(route('zona-integritas.pengaduan.store'), $this->validPayload())
            ->assertSessionHas('pengaduan_success_nomor', '20270500012');

        $this->assertDatabaseHas('zona_integritas_pengaduans', [
            'nomor_pengaduan' => '20270500012',
            'sequence' => 500012,
            'tahun_pengaduan' => 2027,
        ]);

        Carbon::setTestNow();
    }

    public function test_pengaduan_submission_rejects_file_larger_than_five_mb(): void
    {
        $this->from(route('zona-integritas.index', ['tab' => 'pengaduan']))
            ->post(route('zona-integritas.pengaduan.store'), [
                ...$this->validPayload(),
                'bukti_dukung' => UploadedFile::fake()->create('bukti.pdf', 5121, 'application/pdf'),
            ])
            ->assertRedirect(route('zona-integritas.index', ['tab' => 'pengaduan']))
            ->assertSessionHasErrors(['bukti_dukung']);

        $this->assertDatabaseCount('zona_integritas_pengaduans', 0);
    }

    public function test_lacak_pengaduan_displays_status_and_result(): void
    {
        $pengaduan = ZonaIntegritasPengaduan::create([
            'nomor_pengaduan' => '20260500001',
            'tahun_pengaduan' => 2026,
            'sequence' => 500001,
            'nama' => 'Pelapor',
            'jenis_pengaduan' => ZonaIntegritasPengaduan::JENIS_PENGADUAN,
            'jenis_pelanggan' => 'pelanggaran-sop',
            'nama_dilaporkan' => 'Terlapor',
            'judul' => 'Pengaduan SOP',
            'uraian' => 'Uraian pengaduan yang lengkap.',
            'status' => ZonaIntegritasPengaduan::STATUS_SELESAI,
            'hasil_teks' => 'Pengaduan telah ditindaklanjuti.',
        ]);

        $view = app(ZonaIntegritasController::class)->index(Request::create('/zona-integritas', 'GET', [
            'tab' => 'pengaduan',
            'lacak_nomor' => $pengaduan->nomor_pengaduan,
        ]));

        $this->assertSame('lacak', $view->getData()['initialPengaduanTab']);
        $this->assertSame($pengaduan->nomor_pengaduan, $view->getData()['trackedPengaduan']->nomor_pengaduan);
        $this->assertSame('Pengaduan selesai', $view->getData()['trackedPengaduan']->status_label);
        $this->assertSame('Pengaduan telah ditindaklanjuti.', $view->getData()['trackedPengaduan']->hasil_teks);
    }

    /**
     * @return array<string, string>
     */
    private function validPayload(): array
    {
        return [
            'nama' => 'Pelapor',
            'jenis_pengaduan' => ZonaIntegritasPengaduan::JENIS_PENGADUAN,
            'jenis_pelanggan' => 'pelanggaran-sop',
            'nama_dilaporkan' => 'Terlapor',
            'judul' => 'Pengaduan SOP',
            'uraian' => 'Uraian pengaduan yang lengkap.',
            'website' => '',
        ];
    }
}
