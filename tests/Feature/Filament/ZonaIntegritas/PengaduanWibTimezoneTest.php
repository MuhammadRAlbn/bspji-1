<?php

namespace Tests\Feature\Filament\ZonaIntegritas;

use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource as HistoryResource;
use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages\ListRiwayatPenghapusanPengaduans;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource as Resource;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ListZonaIntegritasPengaduans;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ViewZonaIntegritasPengaduan;
use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\ZonaIntegritasPengaduanDeletionService;
use App\Services\ZonaIntegritasPengaduanNotificationService;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Facades\FilamentTimezone;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PengaduanWibTimezoneTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('wibDates')]
    public function test_complaint_list_and_details_show_wib_and_preserve_utc(string $utc, string $wibDate): void
    {
        $this->travelTo(Carbon::parse($utc, 'UTC'));
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'hasil_teks' => 'Selesai ditindaklanjuti.']);
        $record->forceFill([
            'created_at' => $utc,
            'updated_at' => Carbon::parse($utc, 'UTC')->addHour(),
            'selesai_at' => Carbon::parse($utc, 'UTC')->addHours(2),
        ])->saveQuietly();
        $before = $record->refresh()->getAttributes();

        $this->get(Resource::getUrl('index'))->assertOk()->assertSee($wibDate.' 01:30:45 WIB');
        $this->get(Resource::getUrl('view', ['record' => $record]))->assertOk()
            ->assertSee($wibDate.' 01:30:45 WIB')
            ->assertSee($wibDate.' 02:30:45 WIB')
            ->assertSee($wibDate.' 03:30:45 WIB');
        $this->assertSame($before, $record->fresh()->getAttributes());
        $this->assertSame($utc, $record->getRawOriginal('created_at'));
        $this->assertSame('UTC', config('app.timezone'));
    }

    #[DataProvider('wibDates')]
    public function test_history_uses_wib_for_existing_utc_complaints_and_deletion(string $utc, string $wibDate): void
    {
        $this->travelTo(Carbon::parse($utc, 'UTC'));
        $actor = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $this->travelTo(Carbon::parse($utc, 'UTC')->addHour());
        app(ZonaIntegritasPengaduanDeletionService::class)->delete($actor, $record, ['deletion_reason' => 'Laporan duplikat.']);
        $history = $record->fresh();
        $before = $history->getAttributes();
        $this->actingAs(User::factory()->create(['role' => 'kepala_balai']));

        $this->get(HistoryResource::getUrl('index'))->assertOk()->assertSee($wibDate.' 02:30:45 WIB');
        $this->get(HistoryResource::getUrl('view', ['record' => $history]))->assertOk()
            ->assertSee($wibDate.' 01:30:45 WIB')->assertSee($wibDate.' 02:30:45 WIB');
        $this->assertSame($before, $history->fresh()->getAttributes());
        $this->assertSame($utc, $history->getRawOriginal('created_at'));
        $this->assertSame(Carbon::parse($utc, 'UTC')->addHour()->format('Y-m-d H:i:s'), $history->getRawOriginal('deleted_at'));
    }

    public function test_filament_default_datetime_uses_wib_while_date_only_keeps_its_date(): void
    {
        $this->assertSame('Asia/Jakarta', FilamentTimezone::get());
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        $schema = Livewire::test(ViewZonaIntegritasPengaduan::class, ['record' => $record->id])->instance()->infolist;
        $table = Livewire::test(ListZonaIntegritasPengaduans::class)->instance()->getTable();
        $utc = '2026-10-03 18:30:45';
        $entry = TextEntry::make('created_at')->container($schema)->dateTime('d/m/Y H:i:s');
        $this->assertSame('04/10/2026 01:30:45', $entry->formatState($utc));
        $dateOnlyEntry = TextEntry::make('date')->container($schema)->date('d/m/Y');
        $this->assertSame('03/10/2026', $dateOnlyEntry->formatState($utc));

        $column = TextColumn::make('created_at')->table($table)->dateTime('d/m/Y H:i:s');
        $this->assertSame('04/10/2026 01:30:45', $column->formatState($utc));
        $dateOnlyColumn = TextColumn::make('date')->table($table)->date('d/m/Y');
        $this->assertSame('03/10/2026', $dateOnlyColumn->formatState($utc));
    }

    public function test_unfinished_complaints_keep_a_placeholder_for_completion_time(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        $this->get(Resource::getUrl('view', ['record' => $record]))->assertOk()->assertSee('Selesai');
        $schema = Livewire::test(ViewZonaIntegritasPengaduan::class, ['record' => $record->id])->instance()->infolist;
        $entry = collect($schema->getFlatComponents())->first(fn ($component): bool => $component instanceof TextEntry && $component->getName() === 'selesai_at');
        $this->assertNotNull($entry);
        $this->assertNull($entry->formatState($entry->getState()));
        $this->assertSame('-', $entry->getPlaceholder());
    }

    public function test_whatsapp_still_displays_the_same_wib_instant(): void
    {
        $this->travelTo(Carbon::parse('2026-12-31 18:30:45', 'UTC'));
        $record = $this->pengaduan();
        $message = app(ZonaIntegritasPengaduanNotificationService::class)->buildMessage($record);
        $this->assertStringContainsString('01:30 WIB', $message);
        $this->assertStringContainsString('2027', $message);
        $this->assertSame('2026-12-31 18:30:45', $record->getRawOriginal('created_at'));
    }

    public function test_history_order_remains_chronological_in_wib(): void
    {
        $actor = User::factory()->create(['role' => 'admin']);
        $this->travelTo(Carbon::parse('2026-10-03 16:30:45', 'UTC'));
        $older = $this->pengaduan();
        app(ZonaIntegritasPengaduanDeletionService::class)->delete($actor, $older, ['deletion_reason' => 'Laporan duplikat.']);
        $this->travelTo(Carbon::parse('2026-10-03 18:30:45', 'UTC'));
        $newer = $this->pengaduan(['nomor_pengaduan' => '20260000002', 'sequence' => 2]);
        app(ZonaIntegritasPengaduanDeletionService::class)->delete($actor, $newer, ['deletion_reason' => 'Laporan duplikat.']);
        $this->actingAs($actor);
        Livewire::test(ListRiwayatPenghapusanPengaduans::class)->assertCanSeeTableRecords([$newer, $older], inOrder: true)
            ->assertSee('04/10/2026 01:30:45 WIB')->assertSee('03/10/2026 23:30:45 WIB');
    }

    public static function wibDates(): array
    {
        return [
            'midnight' => ['2026-10-03 18:30:45', '04/10/2026'],
            'new-year' => ['2026-12-31 18:30:45', '01/01/2027'],
        ];
    }

    private function pengaduan(array $attributes = []): ZonaIntegritasPengaduan
    {
        return ZonaIntegritasPengaduan::create([
            'nomor_pengaduan' => '20260000001', 'tahun_pengaduan' => 2026, 'sequence' => 1,
            'nama' => 'Pelapor', 'email' => 'pelapor@example.test', 'jenis_pengaduan' => 'pengaduan',
            'judul' => 'Laporan SOP', 'uraian' => 'Uraian laporan lengkap.', 'status' => ZonaIntegritasPengaduan::STATUS_DITOLAK,
            ...$attributes,
        ])->refresh();
    }
}
