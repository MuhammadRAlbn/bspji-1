<?php

namespace Tests\Feature\Filament\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\UserManagementService;
use Filament\Actions\Testing\TestAction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_accounts_without_an_explicit_role_do_not_become_admins(): void
    {
        $attributes = ['name' => 'Tanpa Role', 'email' => 'unassigned@example.test', 'password' => Hash::make('example-password')];
        $model = User::create($attributes);
        $id = DB::table('users')->insertGetId([...$attributes, 'email' => 'database-default@example.test']);

        $this->assertSame('unassigned', $model->refresh()->role);
        $this->assertSame('unassigned', User::findOrFail($id)->role);
        $this->assertFalse($model->canAccessPanel(filament()->getPanel('admin')));
    }

    #[DataProvider('staffRoles')]
    public function test_admin_can_create_staff_accounts(string $role): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateUser::class)
            ->fillForm($this->accountData($role))
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'staff@example.test')->firstOrFail();
        $this->assertSame($role, $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue(Hash::check('strong-password-123', $user->password));
        $this->assertTrue($user->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_create_validates_role_email_and_password_confirmation(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        Livewire::test(CreateUser::class)
            ->fillForm([...$this->accountData('invalid'), 'email' => $admin->email, 'password' => 'short', 'password_confirmation' => 'different'])
            ->call('create')
            ->assertHasFormErrors(['email', 'role', 'password']);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_role_is_required_when_creating_an_account(): void
    {
        $this->actingAs(User::factory()->create());
        Livewire::test(CreateUser::class)
            ->fillForm([...$this->accountData('fap'), 'role' => null])
            ->call('create')
            ->assertHasFormErrors(['role' => 'required']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_editing_without_a_password_preserves_the_existing_hash(): void
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create(['role' => 'fap']);
        $hash = $user->password;

        Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertFormSet(['password' => null])
            ->fillForm(['name' => 'Nama Baru', 'role' => 'kepala_balai', 'password' => '', 'password_confirmation' => ''])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame($hash, $user->refresh()->password);
        $this->assertSame('kepala_balai', $user->role);
        $this->assertSame('Nama Baru', $user->name);
    }

    public function test_admin_can_reset_password_and_deactivate_another_account(): void
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create(['role' => 'fap']);

        Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
            ->fillForm(['password' => 'replacement-password-123', 'password_confirmation' => 'replacement-password-123', 'is_active' => false])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue(Hash::check('replacement-password-123', $user->refresh()->password));
        $this->assertFalse($user->is_active);
        $this->actingAs($user);
        $this->get('/admin')->assertForbidden();
    }

    #[DataProvider('nonAdminRoles')]
    public function test_nonadmins_cannot_manage_accounts(string $role): void
    {
        $staff = User::factory()->create(['role' => $role]);
        $target = User::factory()->create();
        $this->actingAs($staff);

        $this->get(UserResource::getUrl('index'))->assertForbidden();
        $this->get(UserResource::getUrl('create'))->assertForbidden();
        $this->get(UserResource::getUrl('edit', ['record' => $target]))->assertForbidden();
        Livewire::test(CreateUser::class)->assertForbidden();
        Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])->assertForbidden();
    }

    public function test_admin_cannot_deactivate_or_demote_their_own_account(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        Livewire::test(EditUser::class, ['record' => $admin->getRouteKey()])
            ->fillForm(['is_active' => false])
            ->call('save')
            ->assertHasFormErrors(['is_active']);

        Livewire::test(EditUser::class, ['record' => $admin->getRouteKey()])
            ->fillForm(['role' => 'fap'])
            ->call('save')
            ->assertHasFormErrors(['role']);

        $this->assertTrue($admin->refresh()->is_active);
        $this->assertSame('admin', $admin->role);
    }

    public function test_a_stale_admin_cannot_demote_the_remaining_admin(): void
    {
        $first = User::factory()->create();
        $second = User::factory()->create();
        $service = app(UserManagementService::class);

        $service->update($first, $second, ['role' => 'fap']);

        try {
            $service->update($second, $first, ['role' => 'fap']);
            $this->fail('An actor whose admin role was revoked must not update accounts.');
        } catch (AuthorizationException) {
            $this->assertSame('admin', $first->refresh()->role);
        }
    }

    public function test_account_edit_rechecks_the_actor_before_saving(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->create(['role' => 'fap']);
        $this->actingAs($admin);
        $component = Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])->set('data.role', 'admin');
        User::whereKey($admin->getKey())->update(['is_active' => false]);

        $component->call('save')->assertForbidden();
        $this->assertSame('fap', $target->refresh()->role);
    }

    public function test_revoked_account_can_reach_login_after_the_denied_request(): void
    {
        $user = User::factory()->create(['role' => 'fap']);
        $this->actingAs($user);
        User::whereKey($user->getKey())->update(['is_active' => false]);
        $this->get('/admin')->assertForbidden();
        $this->get(route('filament.admin.auth.login'))->assertOk();
        $this->assertGuest();
    }

    public function test_list_delete_requires_confirmation_and_can_be_cancelled(): void
    {
        $this->actingAs(User::factory()->create());
        $target = User::factory()->fap()->create();
        $action = TestAction::make('delete')->table($target);
        $component = Livewire::test(ListUsers::class)
            ->assertActionVisible($action)
            ->mountAction($action)
            ->assertActionMounted($action);
        $description = $component->instance()->getMountedAction()->getModalDescription();
        $this->assertStringContainsString('Penghapusan permanen', $description);
        $this->assertStringContainsString($target->email, $description);
        $this->assertModelExists($target);

        $component->call('unmountAction')->assertActionNotMounted();
        $this->assertModelExists($target);

        $component->callAction($action)->assertNotified();
        $this->assertModelMissing($target);
    }

    public function test_edit_header_can_delete_another_account_and_redirect_to_list(): void
    {
        $this->actingAs(User::factory()->create());
        $target = User::factory()->kepalaBalai()->create();
        Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
            ->assertActionVisible('delete')
            ->callAction('delete')
            ->assertNotified()
            ->assertRedirect(UserResource::getUrl('index'));
        $this->assertModelMissing($target);
    }

    #[DataProvider('deletableAccounts')]
    public function test_admin_can_delete_other_roles_and_inactive_accounts(string $role, bool $active): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->create(['role' => $role, 'is_active' => $active]);
        $this->assertTrue(app(UserManagementService::class)->delete($admin, $target));
        $this->assertModelMissing($target);
        $this->assertModelExists($admin);
    }

    #[DataProvider('adminCounts')]
    public function test_admin_cannot_delete_their_own_account_even_with_other_admins(int $count): void
    {
        $admin = User::factory()->create();
        User::factory()->count($count - 1)->create();
        $this->actingAs($admin);
        $this->assertFalse(Gate::allows('delete', $admin));
        Livewire::test(ListUsers::class)
            ->assertActionHidden(TestAction::make('delete')->table($admin))
            ->mountAction(TestAction::make('delete')->table($admin))->assertActionNotMounted()
            ->selectTableRecords([$admin->getKey()])
            ->mountAction(TestAction::make('delete')->table()->bulk())->assertActionNotMounted();
        Livewire::test(EditUser::class, ['record' => $admin->getRouteKey()])
            ->assertActionHidden('delete')
            ->mountAction('delete')->assertActionNotMounted();

        try {
            app(UserManagementService::class)->delete($admin, $admin);
            $this->fail('Deleting the current admin must be rejected by the service.');
        } catch (AuthorizationException) {
            $this->assertModelExists($admin);
            $this->assertSame($count, User::where('role', 'admin')->where('is_active', true)->count());
        }
    }

    #[DataProvider('unauthorizedDeleteActors')]
    public function test_nonadmin_or_inactive_actor_cannot_delete_accounts(string $role, bool $active): void
    {
        $actor = User::factory()->create(['role' => $role, 'is_active' => $active]);
        $target = User::factory()->create();
        try {
            app(UserManagementService::class)->delete($actor, $target);
            $this->fail('Deleting accounts requires an active admin.');
        } catch (AuthorizationException) {
            $this->assertModelExists($target);
        }
    }

    public function test_delete_rechecks_revoked_or_deleted_actors_and_preserves_the_remaining_admin(): void
    {
        $first = User::factory()->create();
        $second = User::factory()->create();
        $service = app(UserManagementService::class);
        $service->update($first, $second, ['role' => 'fap']);
        try {
            $service->delete($second, $first);
            $this->fail('The stale admin role must not authorize deletion.');
        } catch (AuthorizationException) {
            $this->assertModelExists($first);
        }

        $service->delete($first, $second);
        try {
            $service->delete($second, $first);
            $this->fail('A deleted actor must not delete the remaining admin.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
            $this->assertModelExists($first);
        }
    }

    public function test_delete_rechecks_actor_after_confirmation_dialog_was_opened(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->fap()->create();
        $this->actingAs($admin);
        $component = Livewire::test(ListUsers::class)->mountAction(TestAction::make('delete')->table($target));
        User::whereKey($admin->getKey())->update(['role' => 'fap']);
        $component->callMountedAction()->assertForbidden();
        $this->assertModelExists($target);
    }

    public function test_delete_removes_only_target_sessions_and_reset_token_and_preserves_content(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->fap()->create();
        $report = ZonaIntegritasPengaduan::create([
            'nomor_pengaduan' => '20260500001', 'tahun_pengaduan' => 2026, 'sequence' => 500001,
            'nama' => 'Pelapor', 'email' => 'pelapor@example.test', 'jenis_pengaduan' => 'pengaduan',
            'judul' => 'Laporan tetap tersimpan', 'uraian' => 'Isi laporan tidak bergantung pada akun panel.',
        ]);
        $targetToken = Password::createToken($target);
        $adminToken = Password::createToken($admin);
        config(['session.driver' => 'database', 'session.connection' => null, 'session.table' => 'sessions']);
        foreach (['target-session' => $target, 'admin-session' => $admin] as $id => $user) {
            DB::table('sessions')->insert(['id' => $id, 'user_id' => $user->getKey(), 'payload' => '', 'last_activity' => time()]);
        }

        app(UserManagementService::class)->delete($admin, $target);
        $this->assertModelMissing($target);
        $this->assertDatabaseMissing('sessions', ['id' => 'target-session']);
        $this->assertDatabaseHas('sessions', ['id' => 'admin-session']);
        $this->assertFalse(Password::tokenExists($target, $targetToken));
        $this->assertTrue(Password::tokenExists($admin, $adminToken));
        $this->assertModelExists($report);
    }

    public function test_deleted_account_loses_cached_session_and_cannot_login_again(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->fap()->create(['password' => 'deleted-account-password']);
        $this->actingAs($target);
        app(UserManagementService::class)->delete($admin, $target);
        $this->get('/admin')->assertForbidden();
        $this->assertGuest();
        $this->get(route('filament.admin.auth.login'))->assertOk();
        $this->assertFalse(auth()->attempt(['email' => $target->email, 'password' => 'deleted-account-password']));
    }

    public function test_deleted_actor_cannot_submit_an_open_form_or_signed_upload(): void
    {
        Storage::fake('tmp-for-tests');
        $actor = User::factory()->create();
        $otherAdmin = User::factory()->create();
        $target = User::factory()->fap()->create();
        $this->actingAs($actor);
        $component = Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])->set('data.name', 'Tidak boleh tersimpan');
        $url = URL::temporarySignedRoute('livewire.upload-file', now()->addMinutes(5));
        app(UserManagementService::class)->delete($otherAdmin, $actor);

        $component->call('save')->assertForbidden();
        $this->assertNotSame('Tidak boleh tersimpan', $target->refresh()->name);
        $this->post($url, ['files' => [UploadedFile::fake()->image('hasil.png')]])->assertForbidden();
        $this->assertSame([], Storage::disk('tmp-for-tests')->allFiles('livewire-tmp'));
    }

    public static function deletableAccounts(): array
    {
        return [['fap', true], ['kepala_balai', true], ['humas', true], ['admin', true], ['admin', false], ['unassigned', true]];
    }

    public static function adminCounts(): array
    {
        return [[1], [2]];
    }

    public static function unauthorizedDeleteActors(): array
    {
        return [['fap', true], ['kepala_balai', true], ['humas', true], ['unassigned', true], ['invalid', true], ['admin', false]];
    }

    public static function staffRoles(): array
    {
        return [['fap'], ['kepala_balai']];
    }

    public static function nonAdminRoles(): array
    {
        return [['fap'], ['kepala_balai'], ['humas']];
    }

    private function accountData(string $role): array
    {
        return ['name' => 'Staff', 'email' => 'staff@example.test', 'role' => $role, 'is_active' => true, 'password' => 'strong-password-123', 'password_confirmation' => 'strong-password-123'];
    }
}
