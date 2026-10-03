<?php

namespace Tests\Feature\Filament\ZonaIntegritas;

use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource as HistoryResource;
use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages\ListRiwayatPenghapusanPengaduans;
use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages\ViewRiwayatPenghapusanPengaduan;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource as Resource;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\EditZonaIntegritasPengaduan;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ListZonaIntegritasPengaduans;
use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\UserManagementService;
use App\Services\ZonaIntegritasPengaduanDeletionService;
use App\Services\ZonaIntegritasPengaduanFollowUpService;
use Filament\Actions\Testing\TestAction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

class PengaduanDeletionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_deletion_preserves_the_report_files_and_server_generated_history(): void
    {
        $this->freezeTime();
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $before = $record->getAttributes();
        $this->assertTrue($this->deleteComplaint($admin, $record, [
            'deletion_reason' => '  Duplikat laporan nomor 20260500002.  ',
            'deleted_by_id' => 999, 'deleted_by_name' => 'Pelaku palsu',
            'deleted_at' => '2020-01-01', 'judul' => 'Judul palsu', 'status' => 'invalid',
        ]));

        $history = ZonaIntegritasPengaduan::onlyTrashed()->findOrFail($record->id);
        $this->assertNull(ZonaIntegritasPengaduan::find($record->id));
        $this->assertSoftDeleted($record);
        $this->assertSame('Duplikat laporan nomor 20260500002.', $history->deletion_reason);
        $this->assertSame($admin->id, $history->deleted_by_id);
        $this->assertSame($admin->name, $history->deleted_by_name);
        $this->assertSame($admin->email, $history->deleted_by_email);
        $this->assertSame(now()->format('Y-m-d H:i:s'), $history->deleted_at->format('Y-m-d H:i:s'));
        foreach ([...$record->getFillable(), 'id', 'created_at'] as $field) {
            $this->assertEquals($before[$field] ?? null, $history->getRawOriginal($field), $field);
        }
        Storage::disk('local')->assertExists(['bukti.pdf', 'hasil.pdf']);
    }

    #[DataProvider('invalidReasons')]
    public function test_invalid_manual_reason_cannot_delete_a_complaint(mixed $reason): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        try {
            $this->deleteComplaint($admin, $record, ['deletion_reason' => $reason]);
            $this->fail('Alasan tidak valid harus ditolak.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('deletion_reason', $exception->errors());
        }
        $this->assertNotSoftDeleted($record);
        $this->assertNull($record->refresh()->deletion_reason);
        $this->assertNull($record->deleted_by_id);
    }

    #[DataProvider('otherStatuses')]
    public function test_only_rejected_complaints_can_be_deleted(string $status): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan(['status' => $status]);
        $this->assertFalse(Gate::forUser($admin)->allows('delete', $record));
        $this->expectException(AuthorizationException::class);
        $this->deleteComplaint($admin, $record);
    }

    #[DataProvider('nonDeletingAccounts')]
    public function test_only_an_active_admin_can_use_the_deletion_service(string $role, bool $active): void
    {
        $actor = User::factory()->create(['role' => $role, 'is_active' => $active]);
        $record = $this->pengaduan();
        try {
            $this->deleteComplaint($actor, $record);
            $this->fail('Akun ini tidak boleh menghapus.');
        } catch (AuthorizationException) {
            $this->assertNotSoftDeleted($record);
        }
    }

    public function test_service_rechecks_the_current_actor_and_complaint_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        ZonaIntegritasPengaduan::whereKey($record->id)->update(['status' => ZonaIntegritasPengaduan::STATUS_INVESTIGASI]);
        try {
            $this->deleteComplaint($admin, $record);
            $this->fail('Status terbaru harus diperiksa.');
        } catch (AuthorizationException) {
            $this->assertNotSoftDeleted($record);
        }
        ZonaIntegritasPengaduan::whereKey($record->id)->update(['status' => ZonaIntegritasPengaduan::STATUS_DITOLAK]);
        User::whereKey($admin->id)->update(['role' => 'fap']);
        try {
            $this->deleteComplaint($admin, $record);
            $this->fail('Role terbaru harus diperiksa.');
        } catch (AuthorizationException) {
            $this->assertNotSoftDeleted($record);
        }
    }

    public function test_a_deleted_admin_cannot_complete_an_old_delete_request(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $admin->delete();
        try {
            $this->deleteComplaint($admin, $record);
            $this->fail('Akun terhapus tidak boleh menghapus pengaduan.');
        } catch (AuthorizationException) {
            $this->assertNotSoftDeleted($record);
            $this->assertNull($record->refresh()->deletion_reason);
        }
    }

    public function test_delete_dialog_rejects_a_non_text_reason_without_a_server_error(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $record = $this->pengaduan();
        Livewire::test(ListZonaIntegritasPengaduans::class)
            ->callAction(TestAction::make('delete')->table($record), data: ['deletion_reason' => ['alasan palsu']])
            ->assertHasActionErrors(['deletion_reason']);
        $this->assertNotSoftDeleted($record);
    }

    #[DataProvider('persistenceFailureEvents')]
    public function test_failure_to_persist_history_or_soft_delete_rolls_back_everything(string $event): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $before = $record->getAttributes();
        Event::listen('eloquent.'.$event.': '.ZonaIntegritasPengaduan::class, function (): void {
            throw new RuntimeException('Simulasi kegagalan penyimpanan histori.');
        });
        try {
            $this->deleteComplaint($admin, $record);
            $this->fail('Kegagalan penyimpanan harus membatalkan transaksi.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Simulasi kegagalan penyimpanan histori.', $exception->getMessage());
        }
        $this->assertEquals($before, $record->refresh()->getAttributes());
        $this->assertNull($record->deleted_at);
        $this->assertNull($record->deletion_reason);
        $this->assertNull($record->deleted_by_id);
        Storage::disk('local')->assertExists(['bukti.pdf', 'hasil.pdf']);
    }

    public function test_repeated_deletion_cannot_replace_the_original_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $this->deleteComplaint($admin, $record);
        $before = $record->fresh()->getAttributes();
        try {
            $this->deleteComplaint($admin, $record, ['deletion_reason' => 'Alasan pengganti']);
            $this->fail('Penghapusan ulang harus ditolak.');
        } catch (ModelNotFoundException) {
            $this->assertSame($before, $record->fresh()->getAttributes());
        }
    }

    #[DataProvider('deletionLocations')]
    public function test_both_delete_dialogs_require_a_reason_and_preserve_history(string $location): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $record = $this->pengaduan();
        [$component, $action] = $this->deleteComponent($location, $record);
        $component->mountAction($action)->assertMountedActionModalSee($record->nomor_pengaduan);
        $this->assertNotSoftDeleted($record);
        $component->unmountAction();
        $this->assertNotSoftDeleted($record);
        $component->callAction($action, data: ['deletion_reason' => '   '])->assertHasActionErrors(['deletion_reason']);
        $this->assertNotSoftDeleted($record);
        $component->setActionData(['deletion_reason' => 'Laporan duplikat; sudah ditangani pada nomor lain.'])->callMountedAction()
            ->assertHasNoActionErrors();
        $this->assertSoftDeleted($record);
        $this->assertSame('Laporan duplikat; sudah ditangani pada nomor lain.', $record->fresh()->deletion_reason);
        if ($location === 'edit') {
            $component->assertRedirect(Resource::getUrl('index'));
        }
    }

    public function test_delete_and_bulk_actions_are_unavailable_for_other_statuses(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $record = $this->pengaduan(['status' => ZonaIntegritasPengaduan::STATUS_DITERIMA]);
        $component = Livewire::test(ListZonaIntegritasPengaduans::class)
            ->assertActionHidden(TestAction::make('delete')->table($record));
        $this->assertSame([], $component->instance()->getTable()->getBulkActions());
        Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->id])->assertActionHidden('delete');
        $this->assertFalse(Gate::forUser($admin)->allows('deleteAny', ZonaIntegritasPengaduan::class));
    }

    public function test_open_delete_dialog_cannot_delete_after_status_changes(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $record = $this->pengaduan();
        $component = Livewire::test(ListZonaIntegritasPengaduans::class)
            ->mountAction(TestAction::make('delete')->table($record))
            ->setActionData(['deletion_reason' => 'Laporan duplikat.']);
        ZonaIntegritasPengaduan::whereKey($record->id)->update(['status' => ZonaIntegritasPengaduan::STATUS_INVESTIGASI]);
        $component->callMountedAction();
        $this->assertNotSoftDeleted($record);
        $this->assertNull($record->refresh()->deletion_reason);
    }

    public function test_open_delete_dialog_cannot_delete_after_admin_access_is_revoked(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $record = $this->pengaduan();
        $component = Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->id])
            ->mountAction('delete')->setActionData(['deletion_reason' => 'Laporan duplikat.']);
        User::whereKey($admin->id)->update(['is_active' => false]);
        $component->callMountedAction()->assertForbidden();
        $this->assertNotSoftDeleted($record);
    }

    #[DataProvider('historyReaders')]
    public function test_authorized_readers_can_search_history_and_read_escaped_details(string $role): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $active = $this->pengaduan(['nomor_pengaduan' => '20260500002', 'sequence' => 500002]);
        $reason = '<script>alert("alasan")</script> Laporan duplikat.';
        $this->deleteComplaint($admin, $record, ['deletion_reason' => $reason]);
        $history = $record->fresh();
        $this->actingAs(User::factory()->create(['role' => $role]));
        $this->get(HistoryResource::getUrl('index'))->assertOk();
        $this->get(HistoryResource::getUrl('view', ['record' => $history]))
            ->assertOk()->assertSee($reason)->assertDontSee($reason, false)
            ->assertSee($admin->name)->assertSee($admin->email)->assertSee($record->uraian);
        Livewire::test(ListRiwayatPenghapusanPengaduans::class)
            ->assertCanSeeTableRecords([$history])->assertCanNotSeeTableRecords([$active])
            ->searchTable('Laporan duplikat')->assertCanSeeTableRecords([$history])
            ->searchTable('tidak-ada')->assertCanNotSeeTableRecords([$history]);
        $this->get(Resource::getUrl('view', ['record' => $record]))->assertNotFound();
        Livewire::test(ListZonaIntegritasPengaduans::class)->assertCanNotSeeTableRecords([$history]);
        $this->assertFalse(HistoryResource::canCreate());
        $this->assertFalse(HistoryResource::canEdit($history));
        $this->assertFalse(HistoryResource::canDelete($history));
        $this->assertFalse(HistoryResource::canDeleteAny());
        $this->assertFalse(HistoryResource::canRestore($history));
        $this->assertFalse(HistoryResource::canForceDelete($history));
        $this->assertSame(['index', 'view'], array_keys(HistoryResource::getPages()));
    }

    #[DataProvider('historyDeniedAccounts')]
    public function test_history_urls_components_and_files_reject_unauthorized_accounts(string $role, bool $active): void
    {
        $record = $this->pengaduan();
        $this->deleteComplaint(User::factory()->create(['role' => 'admin']), $record);
        $this->actingAs(User::factory()->create(['role' => $role, 'is_active' => $active]));
        $this->assertFalse(HistoryResource::canAccess());
        $this->get(HistoryResource::getUrl('index'))->assertForbidden();
        Livewire::test(ListRiwayatPenghapusanPengaduans::class)->assertForbidden();
        $this->get(HistoryResource::getUrl('view', ['record' => $record]))->assertForbidden();
        $this->get($this->historyFileUrl($record))->assertForbidden();
    }

    public function test_history_guests_must_log_in(): void
    {
        $record = $this->pengaduan();
        $this->deleteComplaint(User::factory()->create(['role' => 'admin']), $record);
        $this->get(HistoryResource::getUrl('index'))->assertRedirect(route('filament.admin.auth.login'));
        $this->get($this->historyFileUrl($record))->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_history_identity_survives_account_changes_and_permanent_account_deletion(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $id = $admin->id;
        $name = $admin->name;
        $email = $admin->email;
        $record = $this->pengaduan();
        $this->deleteComplaint($admin, $record);
        $admin->update(['name' => 'Nama baru', 'email' => 'baru@example.test']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);
        $this->assertTrue(app(UserManagementService::class)->delete($otherAdmin, $admin));
        $history = $record->fresh();
        $this->assertSame($id, $history->deleted_by_id);
        $this->assertSame($name, $history->deleted_by_name);
        $this->assertSame($email, $history->deleted_by_email);
        $this->actingAs($otherAdmin);
        $this->get(HistoryResource::getUrl('view', ['record' => $history]))->assertOk()->assertSee($name)->assertSee($email);
    }

    #[DataProvider('historyMutations')]
    public function test_model_rejects_mutating_restoring_or_permanently_deleting_history(string $operation): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $this->deleteComplaint($admin, $record);
        $history = $record->fresh();
        $before = $history->getAttributes();
        try {
            match ($operation) {
                'save' => $history->forceFill(['deletion_reason' => 'Alasan diubah', 'deleted_at' => null])->save(),
                'restore' => $history->restore(),
                'forceDelete' => $history->forceDelete(),
                'delete' => $history->delete(),
            };
            $this->fail('Riwayat tidak boleh dimutasi.');
        } catch (AuthorizationException) {
            $this->assertSame($before, $history->fresh()->getAttributes());
        }
    }

    public function test_a_normal_delete_cannot_bypass_required_history_metadata(): void
    {
        $record = $this->pengaduan();
        $this->expectException(ValidationException::class);
        $record->delete();
    }

    public function test_a_stale_edit_cannot_change_history_or_its_files(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $fap = User::factory()->create(['role' => 'fap']);
        $this->actingAs($fap);
        $record = $this->pengaduan();
        $component = Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->id])
            ->set('data.hasil_teks', 'Perubahan dari form lama');
        $this->deleteComplaint($admin, $record);
        $before = $record->fresh()->getAttributes();
        $component->call('save')->assertForbidden();
        $this->assertSame($before, $record->fresh()->getAttributes());
        Storage::disk('local')->assertExists(['bukti.pdf', 'hasil.pdf']);
        $this->expectException(ModelNotFoundException::class);
        app(ZonaIntegritasPengaduanFollowUpService::class)->update($fap, $record, ['status' => ZonaIntegritasPengaduan::STATUS_DITERIMA]);
    }

    public function test_history_pages_recheck_access_after_mounting(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $record = $this->pengaduan();
        $this->deleteComplaint($admin, $record);
        $reader = User::factory()->create(['role' => 'kepala_balai']);
        $this->actingAs($reader);
        $list = Livewire::test(ListRiwayatPenghapusanPengaduans::class);
        $view = Livewire::test(ViewRiwayatPenghapusanPengaduan::class, ['record' => $record->id]);
        User::whereKey($reader->id)->update(['role' => 'fap']);
        $list->call('$refresh')->assertForbidden();
        $view->call('$refresh')->assertForbidden();
        $this->get($this->historyFileUrl($record))->assertForbidden();
    }

    #[DataProvider('historyReaders')]
    public function test_deleted_files_are_available_only_through_authenticated_history_routes(string $role): void
    {
        $record = $this->pengaduan();
        $this->deleteComplaint(User::factory()->create(['role' => 'admin']), $record);
        $this->get(route('zona-integritas.index', ['lacak_nomor' => $record->nomor_pengaduan]))
            ->assertOk()->assertViewHas('trackedPengaduan', null);
        $this->get(route('zona-integritas.pengaduan.hasil.download', $record->nomor_pengaduan))->assertNotFound();
        $this->actingAs(User::factory()->create(['role' => $role]));
        $this->get(route('zona-integritas.pengaduan.bukti.download', $record))->assertNotFound();
        $this->get($this->historyFileUrl($record))->assertOk()->assertDownload('bukti.pdf');
        $this->get($this->historyFileUrl($record, 'hasil'))->assertOk()->assertDownload('hasil.pdf');
        Storage::disk('local')->delete('bukti.pdf');
        $this->get($this->historyFileUrl($record))->assertNotFound();
    }

    public function test_history_cannot_resolve_active_records_or_arbitrary_file_types(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $record = $this->pengaduan();
        $this->get(HistoryResource::getUrl('view', ['record' => $record]))->assertNotFound();
        $this->get($this->historyFileUrl($record))->assertNotFound();
        $this->get($this->historyFileUrl($record, 'other'))->assertNotFound();
    }

    public static function invalidReasons(): array
    {
        return [[null], [''], [" \t\n "], ["\u{00A0}\u{200B}"], [['reason']], [str_repeat('a', 2001)]];
    }

    public static function otherStatuses(): array
    {
        return [[ZonaIntegritasPengaduan::STATUS_DITERIMA], [ZonaIntegritasPengaduan::STATUS_INVESTIGASI], [ZonaIntegritasPengaduan::STATUS_SELESAI]];
    }

    public static function nonDeletingAccounts(): array
    {
        return [['fap', true], ['kepala_balai', true], ['humas', true], ['viewer', true], ['admin', false]];
    }

    public static function persistenceFailureEvents(): array
    {
        return [['updating'], ['trashed']];
    }

    public static function deletionLocations(): array
    {
        return [['list'], ['edit']];
    }

    public static function historyReaders(): array
    {
        return [['admin'], ['kepala_balai']];
    }

    public static function historyDeniedAccounts(): array
    {
        return [['fap', true], ['humas', true], ['viewer', true], ['admin', false], ['kepala_balai', false]];
    }

    public static function historyMutations(): array
    {
        return [['save'], ['restore'], ['forceDelete'], ['delete']];
    }

    private function deleteComplaint(User $actor, ZonaIntegritasPengaduan $record, array $data = []): bool
    {
        return app(ZonaIntegritasPengaduanDeletionService::class)->delete($actor, $record, $data ?: ['deletion_reason' => 'Laporan duplikat.']);
    }

    private function historyFileUrl(ZonaIntegritasPengaduan $record, string $document = 'bukti'): string
    {
        return route('zona-integritas.pengaduan.riwayat.download', ['pengaduan' => $record, 'document' => $document]);
    }

    private function deleteComponent(string $location, ZonaIntegritasPengaduan $record): array
    {
        return $location === 'edit'
            ? [Livewire::test(EditZonaIntegritasPengaduan::class, ['record' => $record->id]), 'delete']
            : [Livewire::test(ListZonaIntegritasPengaduans::class), TestAction::make('delete')->table($record)];
    }

    private function pengaduan(array $attributes = []): ZonaIntegritasPengaduan
    {
        Storage::fake('local');
        Storage::disk('local')->put('bukti.pdf', '%PDF-1.4');
        Storage::disk('local')->put('hasil.pdf', '%PDF-1.4');

        return ZonaIntegritasPengaduan::create([
            'nomor_pengaduan' => '20260500001', 'tahun_pengaduan' => 2026, 'sequence' => 500001,
            'nama' => 'Pelapor', 'email' => 'pelapor@example.test', 'jenis_pengaduan' => 'pengaduan',
            'judul' => 'Laporan SOP', 'uraian' => 'Uraian laporan lengkap.', 'status' => ZonaIntegritasPengaduan::STATUS_DITOLAK,
            'bukti_dukung_path' => 'bukti.pdf', 'bukti_dukung_nama' => 'bukti.pdf',
            'dokumen_hasil_path' => 'hasil.pdf', 'dokumen_hasil_nama' => 'hasil.pdf',
            ...$attributes,
        ])->refresh();
    }
}
