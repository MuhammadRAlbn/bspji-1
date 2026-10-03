<?php

namespace Tests\Feature\Filament\ZonaIntegritas;

use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource as Resource;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\EditZonaIntegritasPengaduan;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ListZonaIntegritasPengaduans;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ViewZonaIntegritasPengaduan;
use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\ZonaIntegritasPengaduanFollowUpService;
use Filament\Actions\Testing\TestAction;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PengaduanAccessTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('readerRoles')]
    public function test_readers_can_access_list_and_complete_details(string $role): void
    {
        $this->actingAs(User::factory()->create(['role' => $role]));
        $record = $this->pengaduan();
        $this->get(Resource::getUrl('index'))->assertOk();
        $this->get(Resource::getUrl('view', ['record' => $record]))->assertOk()->assertSee($record->uraian);
        Livewire::test(ListZonaIntegritasPengaduans::class)
            ->filterTable('status', ZonaIntegritasPengaduan::STATUS_DITERIMA)
            ->searchTable($record->nomor_pengaduan)
            ->assertCanSeeTableRecords([$record]);
    }

    #[DataProvider('restrictedRoles')]
    public function test_restricted_roles_are_redirected_home_and_cannot_open_other_resources(string $role): void
    {
        $this->actingAs(User::factory()->create(['role' => $role]));
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->get('/admin')->assertRedirect(Resource::getUrl('index'));
        $this->withSession(['url.intended' => '/admin/news']);
        $response = app(LoginResponse::class)->toResponse(request());
        $this->assertSame(Resource::getUrl('index'), $response->getTargetUrl());

        $allowedResources = [Resource::class];
        if ($role === User::ROLE_KEPALA_BALAI) {
            $allowedResources[] = RiwayatPenghapusanPengaduanResource::class;
        }
        foreach (Filament::getPanel('admin')->getResources() as $resource) {
            $allowed = in_array($resource, $allowedResources, true);
            $this->assertSame($allowed, $resource::canAccess(), $resource);
            if (! $allowed) {
                $this->get($resource::getUrl('index'))->assertForbidden();
            }
        }

        $navigation = collect(Filament::getNavigation())->flatMap(fn ($group) => $group->getItems())->map(fn ($item) => $item->getLabel())->values()->all();
        $this->assertSame(['Zona Integritas'], $navigation);
    }

    public function test_kepala_balai_cannot_edit_or_delete(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'kepala_balai']));
        $record = $this->pengaduan();
        $this->get(Resource::getUrl('edit', ['record' => $record]))->assertForbidden();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])->assertForbidden();
        Livewire::test(ViewZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])->assertActionHidden('edit');
        Livewire::test(ListZonaIntegritasPengaduans::class)
            ->assertActionHidden(TestAction::make('edit')->table($record))
            ->assertActionHidden(TestAction::make('delete')->table($record))
            ->mountAction(TestAction::make('delete')->table($record))->assertActionNotMounted()
            ->selectTableRecords([$record->getKey()])
            ->mountAction(TestAction::make('delete')->table()->bulk())->assertActionNotMounted();
        $this->assertModelExists($record);
    }

    public function test_fap_can_update_only_follow_up_fields_and_cannot_delete(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_INVESTIGASI, 'hasil_teks' => 'Sedang ditindaklanjuti.'])
            ->set('data.nama', 'Identitas Diubah')
            ->set('data.judul', 'Judul Diubah')
            ->set('data.selesai_at', '2020-01-01')
            ->call('save')
            ->assertHasNoFormErrors();
        $this->assertSame('Pelapor', $record->refresh()->nama);
        $this->assertSame('Laporan SOP', $record->judul);
        $this->assertNull($record->selesai_at);
        $this->assertSame(ZonaIntegritasPengaduan::STATUS_INVESTIGASI, $record->status);
        Livewire::test(ListZonaIntegritasPengaduans::class)
            ->mountAction(TestAction::make('delete')->table($record))->assertActionNotMounted()
            ->selectTableRecords([$record->getKey()])
            ->mountAction(TestAction::make('delete')->table()->bulk())->assertActionNotMounted();
        $this->assertModelExists($record);
    }

    public function test_completion_requires_text_or_a_valid_document(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'hasil_teks' => '   '])
            ->call('save')->assertHasFormErrors(['hasil_teks']);
        $this->assertSame(ZonaIntegritasPengaduan::STATUS_DITERIMA, $record->refresh()->status);
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'hasil_teks' => 'Pengaduan selesai ditangani.'])
            ->call('save')->assertHasNoFormErrors();
        $this->assertSame(ZonaIntegritasPengaduan::STATUS_SELESAI, $record->refresh()->status);
        $this->assertNotNull($record->selesai_at);
    }

    public function test_removing_the_only_result_document_cannot_leave_a_complaint_completed(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('zona-integritas/pengaduan/hasil/result.pdf', '%PDF-1.4');
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'dokumen_hasil_path' => 'zona-integritas/pengaduan/hasil/result.pdf']);
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['dokumen_hasil_path' => null, 'hasil_teks' => null])
            ->call('save')->assertHasFormErrors(['hasil_teks']);
        $this->assertNotNull($record->refresh()->dokumen_hasil_path);
    }

    public function test_fap_cannot_reference_another_complaints_document(): void
    {
        Storage::fake('local');
        $foreign = 'zona-integritas/pengaduan/hasil/foreign.pdf';
        Storage::disk('local')->put($foreign, '%PDF-1.4');
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'dokumen_hasil_path' => [$foreign]])
            ->call('save')->assertHasFormErrors(['dokumen_hasil_path']);
        $this->assertNull($record->refresh()->dokumen_hasil_path);
    }

    public function test_fap_can_upload_a_valid_result_document(): void
    {
        Storage::fake('local');
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'dokumen_hasil_path' => UploadedFile::fake()->image('hasil.png')])
            ->call('save')->assertHasNoFormErrors();
        $this->assertSame('hasil.png', $record->refresh()->dokumen_hasil_nama);
        Storage::disk('local')->assertExists($record->dokumen_hasil_path);
    }

    #[DataProvider('accessRevocations')]
    public function test_mounted_edit_cannot_save_after_access_is_revoked(array $change): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['role' => 'fap']);
        $this->actingAs($user);
        $record = $this->pengaduan();
        $component = Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])->set('data.hasil_teks', 'Perubahan terlarang');
        User::whereKey($user->getKey())->update($change);
        $component->call('save')->assertForbidden();
        $this->assertNull($record->refresh()->hasil_teks);
        $this->assertSame([], Storage::disk('local')->allFiles('zona-integritas/pengaduan/hasil'));
    }

    public function test_invalid_status_is_rejected(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => 'invalid'])->call('save')->assertHasFormErrors(['status']);
    }

    public function test_nonempty_zero_text_is_a_valid_result(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI, 'hasil_teks' => '0'])
            ->call('save')->assertHasNoFormErrors();
        $this->assertSame('0', $record->refresh()->hasil_teks);
    }

    public function test_an_existing_result_document_can_complete_a_complaint(): void
    {
        Storage::fake('local');
        $path = 'zona-integritas/pengaduan/hasil/valid.pdf';
        Storage::disk('local')->put($path, '%PDF-1.4');
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan(['dokumen_hasil_path' => $path]);
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['status' => ZonaIntegritasPengaduan::STATUS_SELESAI])
            ->call('save')->assertHasNoFormErrors();
        $this->assertSame(ZonaIntegritasPengaduan::STATUS_SELESAI, $record->refresh()->status);
        $this->assertSame($path, $record->dokumen_hasil_path);
    }

    #[DataProvider('invalidUploads')]
    public function test_invalid_uploads_are_rejected(string $type): void
    {
        Storage::fake('local');
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        $file = $type === 'large' ? UploadedFile::fake()->image('besar.png')->size(5121) : UploadedFile::fake()->create('script.txt', 1, 'text/plain');
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['dokumen_hasil_path' => $file])->call('save')
            ->assertHasFormErrors(['dokumen_hasil_path']);
        $this->assertNull($record->refresh()->dokumen_hasil_path);
        $this->assertSame([], Storage::disk('local')->allFiles('zona-integritas/pengaduan/hasil'));
    }

    public function test_foreign_document_preview_does_not_expose_file_metadata(): void
    {
        Storage::fake('local');
        $foreign = 'zona-integritas/pengaduan/hasil/rahasia.pdf';
        Storage::disk('local')->put($foreign, '%PDF-1.4');
        $this->actingAs(User::factory()->create(['role' => 'fap']));
        $record = $this->pengaduan();
        $component = Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->getRouteKey()])
            ->fillForm(['dokumen_hasil_path' => [$foreign]]);
        $field = collect($component->instance()->form->getFlatComponents())->first(fn ($field): bool => $field instanceof FileUpload);
        $this->assertNotNull($field);
        $this->assertSame([null], array_values($field->getUploadedFiles()));
    }

    public function test_service_rejects_changes_to_report_data_and_server_generated_metadata(): void
    {
        $user = User::factory()->create(['role' => 'fap']);
        $record = $this->pengaduan();
        app(ZonaIntegritasPengaduanFollowUpService::class)->update($user, $record, [
            'status' => ZonaIntegritasPengaduan::STATUS_INVESTIGASI, 'hasil_teks' => 'Investigasi',
            'nama' => 'Nama palsu', 'uraian' => 'Isi palsu', 'nomor_pengaduan' => '123',
            'dokumen_hasil_nama' => 'palsu.pdf', 'bukti_dukung_path' => 'palsu.pdf', 'selesai_at' => '2020-01-01',
        ]);
        $this->assertSame('Pelapor', $record->refresh()->nama);
        $this->assertSame('20260500001', $record->nomor_pengaduan);
        $this->assertNull($record->dokumen_hasil_nama);
        $this->assertNull($record->bukti_dukung_path);
        $this->assertNull($record->selesai_at);
    }

    public static function invalidUploads(): array
    {
        return [['large'], ['mime']];
    }

    #[DataProvider('accessRevocations')]
    public function test_signed_upload_url_is_rejected_after_access_revocation(array $change): void
    {
        Storage::fake('tmp-for-tests');
        $user = User::factory()->create(['role' => 'fap']);
        $this->actingAs($user);
        $url = URL::temporarySignedRoute('livewire.upload-file', now()->addMinutes(5));
        User::whereKey($user->getKey())->update($change);
        $this->post($url, ['files' => [UploadedFile::fake()->image('hasil.png')]])->assertForbidden();
        $this->assertSame([], Storage::disk('tmp-for-tests')->allFiles('livewire-tmp'));
    }

    #[DataProvider('uploadRoles')]
    public function test_signed_upload_is_available_only_to_active_editors(string $role, int $status): void
    {
        Storage::fake('tmp-for-tests');
        $this->actingAs(User::factory()->create(['role' => $role]));
        $url = URL::temporarySignedRoute('livewire.upload-file', now()->addMinutes(5));
        $this->post($url, ['files' => [UploadedFile::fake()->image('hasil.png')]])->assertStatus($status);
    }

    public static function uploadRoles(): array
    {
        return [['admin', 200], ['humas', 200], ['fap', 200], ['kepala_balai', 403]];
    }

    public static function readerRoles(): array
    {
        return [['admin'], ['fap'], ['kepala_balai']];
    }

    public static function restrictedRoles(): array
    {
        return [['fap'], ['kepala_balai']];
    }

    public static function accessRevocations(): array
    {
        return [[['is_active' => false]], [['role' => 'kepala_balai']]];
    }

    private function pengaduan(array $attributes = []): ZonaIntegritasPengaduan
    {
        return ZonaIntegritasPengaduan::create([...[
            'nomor_pengaduan' => '20260500001', 'tahun_pengaduan' => 2026, 'sequence' => 500001,
            'nama' => 'Pelapor', 'email' => 'pelapor@example.test', 'jenis_pengaduan' => 'pengaduan',
            'judul' => 'Laporan SOP', 'uraian' => 'Uraian laporan lengkap untuk pemeriksaan Kepala Balai.',
        ], ...$attributes]);
    }
}
