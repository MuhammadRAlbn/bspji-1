<?php

namespace Tests\Feature\Filament;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use App\Filament\Pages\ChangePassword;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\AccountSessionService;
use App\Services\UserManagementService;
use App\Services\UserPasswordService;
use Filament\Facades\Filament;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

class PasswordManagementTest extends TestCase
{
    use RefreshDatabase;

    private const string OLD_PASSWORD = 'Password awal 123';

    private const string NEW_PASSWORD = 'Password baru 456';

    protected function setUp(): void
    {
        parent::setUp();
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    #[DataProvider('roles')]
    public function test_all_active_roles_have_a_password_only_page_and_optional_business_access(string $role): void
    {
        $user = $this->user($role);
        $this->authenticate($user);
        $this->get('/admin/ubah-password')->assertOk()->assertSee('Ubah Password')->assertSee('Password Saat Ini');
        Livewire::test(ChangePassword::class)
            ->assertFormFieldExists('current_password')
            ->assertFormFieldExists('password')
            ->assertFormFieldExists('password_confirmation')
            ->assertFormFieldDoesNotExist('name')
            ->assertFormFieldDoesNotExist('email')
            ->assertFormFieldDoesNotExist('role')
            ->assertFormSet(['current_password' => null, 'password' => null, 'password_confirmation' => null]);
        $this->assertSame('Ubah Password', ChangePassword::getLabel());
        if ($user->isPengaduanStaff()) {
            $this->get(ZonaIntegritasPengaduanResource::getUrl('index'))->assertOk();
            $this->get('/admin/users')->assertForbidden();
        }
        $this->assertTrue(Hash::check(self::OLD_PASSWORD, $user->fresh()->password));
    }

    public function test_success_changes_only_own_credentials_clears_inputs_and_rotates_current_session(): void
    {
        $user = $this->user();
        $other = $this->user();
        $otherHash = $other->password;
        $attributes = $user->only(['name', 'email', 'role', 'is_active']);
        $this->authenticate($user);
        $sessionId = session()->getId();
        $resetToken = Password::createToken($user);
        $rememberToken = $user->remember_token;
        Livewire::test(ChangePassword::class)->fillForm($this->passwordData())
            ->set('data.id', $other->id)->set('data.role', 'admin')->set('data.is_active', false)
            ->set('data.name', 'Forged')->set('data.email', 'forged@example.test')
            ->call('save')->assertHasNoFormErrors()->assertNotified('Password berhasil diubah.')
            ->assertFormSet(['current_password' => null, 'password' => null, 'password_confirmation' => null]);
        $user->refresh();
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $user->password));
        $this->assertFalse(Hash::check(self::OLD_PASSWORD, $user->password));
        $this->assertSame($attributes, $user->only(['name', 'email', 'role', 'is_active']));
        $this->assertSame($otherHash, $other->fresh()->password);
        $this->assertNotSame($rememberToken, $user->remember_token);
        $this->assertFalse(Password::tokenExists($user, $resetToken));
        $this->assertNotSame($sessionId, session()->getId());
        $this->assertAuthenticatedAs($user);
        $this->assertSame(Auth::guard()->hashPasswordForCookie($user->password), session('password_hash_web'));
        $this->get('/admin/ubah-password')->assertOk();
    }

    #[DataProvider('invalidPasswords')]
    public function test_invalid_passwords_preserve_account_session_and_tokens(array $overrides, string $field): void
    {
        $user = $this->user();
        $this->authenticate($user);
        $hash = $user->password;
        $remember = $user->remember_token;
        $sessionId = session()->getId();
        $token = Password::createToken($user);
        Livewire::test(ChangePassword::class)->fillForm(array_replace($this->passwordData(), $overrides))
            ->call('save')->assertHasFormErrors([$field]);
        $this->assertSame($hash, $user->fresh()->password);
        $this->assertSame($remember, $user->fresh()->remember_token);
        $this->assertSame($sessionId, session()->getId());
        $this->assertTrue(Password::tokenExists($user, $token));
    }

    public function test_password_spaces_are_preserved_and_bcrypt_limit_counts_bytes(): void
    {
        $user = $this->user();
        $this->authenticate($user);
        $password = '  password with spaces  ';
        Livewire::test(ChangePassword::class)->fillForm($this->passwordData($password))
            ->call('save')->assertHasNoFormErrors();
        $this->assertTrue(Hash::check($password, $user->fresh()->password));
        $this->assertFalse(Hash::check(trim($password), $user->fresh()->password));
    }

    #[DataProvider('revokedAccounts')]
    public function test_mounted_page_cannot_save_after_account_access_is_revoked(string $reason): void
    {
        $user = $this->user();
        $this->authenticate($user);
        $page = Livewire::test(ChangePassword::class)->fillForm($this->passwordData());
        if ($reason === 'deleted') {
            $user->delete();
        } else {
            $user->forceFill($reason === 'inactive' ? ['is_active' => false] : ['role' => 'invalid'])->save();
        }
        $page->call('save')->assertForbidden();
        if ($reason !== 'deleted') {
            $this->assertTrue(Hash::check(self::OLD_PASSWORD, $user->fresh()->password));
        }
    }

    public function test_admin_reset_rejects_old_mounted_page_without_overwriting_new_hash(): void
    {
        $user = $this->user();
        $admin = $this->user('admin');
        $this->authenticate($user);
        $page = Livewire::test(ChangePassword::class)->fillForm($this->passwordData());
        app(UserManagementService::class)->update($admin, $user, [
            'password' => 'Password reset admin', 'password_confirmation' => 'Password reset admin',
        ]);
        $this->assertStaleLivewire(fn () => $page->call('save'));
        $this->assertTrue(Hash::check('Password reset admin', $user->fresh()->password));
    }

    public function test_missing_or_stale_session_marker_cannot_access_panel(): void
    {
        $user = $this->user();
        $this->authenticate($user);
        session()->forget('password_hash_web');
        $this->get('/admin/ubah-password')->assertRedirect('/admin/login');
        $this->authenticate($user);
        $oldMarker = session('password_hash_web');
        $user->forceFill(['password' => Hash::make('Password reset admin')])->save();
        $this->withSession(['password_hash_web' => $oldMarker])->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_stale_credentials_are_denied_on_livewire_upload_and_internal_download(): void
    {
        $user = $this->user();
        $this->authenticate($user);
        $page = Livewire::test(ChangePassword::class);
        $oldMarker = session('password_hash_web');
        $user->forceFill(['password' => Hash::make('Password reset admin')])->save();
        $this->assertStaleLivewire(fn () => $page->call('save'));
        $this->authenticate($user->fresh());
        $this->withSession(['password_hash_web' => $oldMarker]);
        $uploadUrl = URL::temporarySignedRoute('livewire.upload-file', now()->addMinute());
        $this->postJson($uploadUrl)->assertUnauthorized();
        $this->authenticate($user->fresh());
        $this->withSession(['password_hash_web' => $oldMarker]);
        $record = ZonaIntegritasPengaduan::create([
            'nomor_pengaduan' => '20260500001', 'tahun_pengaduan' => 2026, 'sequence' => 500001,
            'nama' => 'Pelapor', 'email' => 'pelapor@example.test', 'jenis_pengaduan' => 'pengaduan',
            'judul' => 'Laporan SOP', 'uraian' => 'Laporan pengaduan untuk pengujian sesi.',
        ]);
        $this->get(route('zona-integritas.pengaduan.bukti.download', $record))->assertRedirect('/admin/login');
    }

    public function test_database_sessions_are_revoked_for_self_change_and_admin_reset_but_not_blank_edit(): void
    {
        $user = $this->user();
        $admin = $this->user('admin');
        config(['session.driver' => 'database']);
        $this->authenticate($user);
        $currentId = session()->getId();
        $this->insertSession($currentId, $user);
        $this->insertSession('other-device', $user);
        $this->insertSession('admin-device', $admin);
        app(UserPasswordService::class)->change($user, $this->passwordData(), '127.0.0.1');
        $this->assertDatabaseMissing('sessions', ['id' => 'other-device']);
        $this->assertDatabaseHas('sessions', ['id' => 'admin-device']);
        $this->insertSession('target-new-device', $user);
        $this->authenticate($admin);
        $remember = $user->fresh()->remember_token;
        app(UserManagementService::class)->update($admin, $user, ['name' => 'Edited', 'password' => '']);
        $this->assertDatabaseHas('sessions', ['id' => 'target-new-device']);
        $this->assertSame($remember, $user->fresh()->remember_token);
        $token = Password::createToken($user);
        app(UserManagementService::class)->update($admin, $user, [
            'password' => 'Reset target password', 'password_confirmation' => 'Reset target password',
        ]);
        $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
        $this->assertFalse(Password::tokenExists($user->fresh(), $token));
        $this->assertNotSame($remember, $user->fresh()->remember_token);
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_cannot_bypass_current_password_for_own_account(): void
    {
        $admin = $this->user('admin');
        $this->authenticate($admin);
        Livewire::test(EditUser::class, ['record' => $admin->id])
            ->assertFormFieldIsHidden('password')->assertFormFieldIsHidden('password_confirmation')
            ->assertSee('Ubah Password')->set('data.password', self::NEW_PASSWORD)
            ->set('data.password_confirmation', self::NEW_PASSWORD)->call('save')->assertHasFormErrors(['password']);
        try {
            app(UserManagementService::class)->update($admin, $admin, $this->passwordData());
            $this->fail('Self reset must fail.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('password', $exception->errors());
        }
        $this->assertTrue(Hash::check(self::OLD_PASSWORD, $admin->fresh()->password));
        app(UserManagementService::class)->update($admin, $admin, ['name' => 'New own name']);
        $this->assertSame('New own name', $admin->fresh()->name);
    }

    public function test_admin_creation_and_reset_reject_bcrypt_truncation(): void
    {
        $admin = $this->user('admin');
        $user = $this->user();
        foreach (['create', 'reset'] as $operation) {
            try {
                $data = ['name' => 'Long', 'email' => 'long@example.test', 'role' => 'fap', 'password' => str_repeat('é', 37), 'password_confirmation' => str_repeat('é', 37)];
                $service = app(UserManagementService::class);
                $operation === 'create' ? $service->create($admin, $data) : $service->update($admin, $user, $data);
                $this->fail('Too many bytes must fail.');
            } catch (ValidationException $exception) {
                $this->assertArrayHasKey('password', $exception->errors());
            }
        }
        $this->assertTrue(Hash::check(self::OLD_PASSWORD, $user->fresh()->password));
    }

    public function test_five_attempts_per_account_include_invalid_form_and_expire(): void
    {
        $this->authenticate($this->user());
        $page = Livewire::test(ChangePassword::class);
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $page->fillForm(['current_password' => '', 'password' => '', 'password_confirmation' => ''])->call('save')->assertHasFormErrors();
        }
        $page->fillForm($this->passwordData())->call('save')->assertNotified('Terlalu banyak percobaan.');
        $this->assertTrue(Hash::check(self::OLD_PASSWORD, Auth::user()->fresh()->password));
        $this->travel(61)->seconds();
        $page->call('save')->assertHasNoFormErrors()->assertNotified('Password berhasil diubah.');
    }

    public function test_ip_limit_is_shared_by_different_accounts(): void
    {
        for ($account = 0; $account < 4; $account++) {
            $this->authenticate($this->user());
            $page = Livewire::test(ChangePassword::class);
            for ($attempt = 0; $attempt < 5; $attempt++) {
                $page->fillForm(['current_password' => 'wrong'])->call('save')->assertHasFormErrors();
            }
        }
        $last = $this->user();
        $this->authenticate($last);
        Livewire::test(ChangePassword::class)->fillForm($this->passwordData())->call('save')->assertNotified('Terlalu banyak percobaan.');
        $this->assertTrue(Hash::check(self::OLD_PASSWORD, $last->fresh()->password));
    }

    public function test_attempt_that_crosses_limit_after_admission_check_cannot_change_password(): void
    {
        $user = $this->user();
        $this->authenticate($user);
        RateLimiter::shouldReceive('tooManyAttempts')->twice()->andReturn(false);
        RateLimiter::shouldReceive('hit')->twice()->andReturn(6, 1);
        RateLimiter::shouldReceive('availableIn')->once()->andReturn(60);
        Livewire::test(ChangePassword::class)->fillForm($this->passwordData())->call('save')->assertNotified('Terlalu banyak percobaan.');
        $this->assertTrue(Hash::check(self::OLD_PASSWORD, $user->fresh()->password));
    }

    public function test_failed_session_cleanup_rolls_back_password_remember_and_reset_token(): void
    {
        $user = $this->user();
        $this->authenticate($user);
        $hash = $user->password;
        $remember = $user->remember_token;
        $sessionId = session()->getId();
        $token = Password::createToken($user);
        $sessions = Mockery::mock(AccountSessionService::class)->makePartial();
        $sessions->shouldReceive('revoke')->once()->andReturnUsing(function (User $record): void {
            Password::deleteToken($record);
            throw new RuntimeException('Cleanup gagal pada lingkungan test.');
        });
        app()->instance(AccountSessionService::class, $sessions);
        $this->assertThrows(fn () => app(UserPasswordService::class)->change($user, $this->passwordData(), '127.0.0.1'), RuntimeException::class);
        $this->assertSame($hash, $user->fresh()->password);
        $this->assertSame($remember, $user->fresh()->remember_token);
        $this->assertSame($sessionId, session()->getId());
        $this->assertTrue(Password::tokenExists($user, $token));
    }

    public function test_actual_livewire_update_rejects_snapshot_created_before_reset(): void
    {
        $user = $this->user();
        $admin = $this->user('admin');
        $this->authenticate($user);
        $html = $this->get('/admin/ubah-password')->assertOk()->getContent();
        preg_match_all('/wire:snapshot="([^"]+)"/', $html, $matches);
        $snapshot = collect($matches[1])->map(fn ($value) => html_entity_decode($value, ENT_QUOTES))
            ->first(fn ($value) => json_decode($value, true)['memo']['name'] === ChangePassword::class);
        $this->assertNotNull($snapshot);
        app(UserManagementService::class)->update($admin, $user, [
            'password' => self::NEW_PASSWORD, 'password_confirmation' => self::NEW_PASSWORD,
        ]);
        $this->postJson(Livewire::getUpdateUri(), ['components' => [[
            'snapshot' => $snapshot, 'updates' => [], 'calls' => [['path' => '', 'method' => 'save', 'params' => []]],
        ]]], ['X-Livewire' => 'true'])->assertUnauthorized();
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $user->fresh()->password));
    }

    public function test_two_database_sessions_and_a_recreated_old_row_cannot_regain_access(): void
    {
        config(['session.driver' => 'database']);
        $user = $this->user();
        $this->authenticate($user);
        $guard = Auth::guard();
        session()->put($guard->getName(), $user->id);
        $oldPayload = base64_encode(serialize(session()->all()));
        DB::table('sessions')->insert(['id' => 'other-password-device', 'user_id' => $user->id, 'payload' => $oldPayload, 'last_activity' => time()]);
        app(UserPasswordService::class)->change($user, $this->passwordData(), '127.0.0.1');
        session()->save();
        $newId = session()->getId();
        $this->assertDatabaseMissing('sessions', ['id' => 'other-password-device']);
        $this->withCookie(config('session.cookie'), $newId)->get('/admin/ubah-password')->assertOk();
        DB::table('sessions')->insert(['id' => 'other-password-device', 'user_id' => $user->id, 'payload' => $oldPayload, 'last_activity' => time()]);
        $remember = $user->fresh()->remember_token;
        Auth::forgetGuards();
        session()->flush();
        $this->withCookie(config('session.cookie'), 'other-password-device')->get('/admin/ubah-password')->assertRedirect('/admin/login');
        $this->assertSame($remember, $user->fresh()->remember_token);
    }

    public function test_reset_and_email_change_remove_reset_tokens_for_old_email(): void
    {
        $admin = $this->user('admin');
        $user = $this->user();
        Password::createToken($user);
        $oldEmail = $user->email;
        app(UserManagementService::class)->update($admin, $user, [
            'email' => 'changed@example.test', 'password' => self::NEW_PASSWORD, 'password_confirmation' => self::NEW_PASSWORD,
        ]);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $oldEmail]);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => 'changed@example.test']);
    }

    #[DataProvider('legacyPasswords')]
    public function test_existing_short_or_long_passwords_still_verify_as_current(string $password): void
    {
        $user = $this->user();
        $user->forceFill(['password' => Hash::make($password)])->save();
        $this->authenticate($user);
        Livewire::test(ChangePassword::class)->fillForm([...$this->passwordData(), 'current_password' => $password])
            ->call('save')->assertHasNoFormErrors();
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $user->fresh()->password));
    }

    public function test_bcrypt_accepts_exactly_72_bytes_and_treats_hash_looking_input_as_plaintext(): void
    {
        $user = $this->user();
        $this->authenticate($user);
        $password = str_repeat('é', 36);
        Livewire::test(ChangePassword::class)->fillForm($this->passwordData($password))->call('save')->assertHasNoFormErrors();
        $this->assertTrue(Hash::check($password, $user->fresh()->password));
        $admin = $this->user('admin');
        $hashLookingPassword = Hash::make('Another password');
        app(UserManagementService::class)->update($admin, $user, ['password' => $hashLookingPassword, 'password_confirmation' => $hashLookingPassword]);
        $this->assertTrue(Hash::check($hashLookingPassword, $user->fresh()->password));
        $this->assertFalse(Hash::check('Another password', $user->fresh()->password));
    }

    public function test_real_login_initializes_marker_and_old_password_fails_after_change(): void
    {
        $user = $this->user();
        $this->registerLoginRoute();
        $this->post('/test-password-login', ['email' => $user->email, 'password' => self::OLD_PASSWORD])->assertRedirect('/admin/ubah-password');
        $this->assertSame(Auth::guard()->hashPasswordForCookie($user->password), session('password_hash_web'));
        Livewire::test(ChangePassword::class)->fillForm($this->passwordData())->call('save')->assertHasNoFormErrors();
        Auth::logout();
        $this->post('/test-password-login', ['email' => $user->email, 'password' => self::OLD_PASSWORD])->assertUnprocessable();
        $this->post('/test-password-login', ['email' => $user->email, 'password' => self::NEW_PASSWORD])->assertRedirect('/admin/ubah-password');
        $this->get('/admin/ubah-password')->assertOk();
    }

    public function test_new_credential_login_with_remember_works_even_when_old_cookie_remains(): void
    {
        $user = $this->user();
        $this->registerLoginRoute();
        $guard = Auth::guard();
        $oldCookie = $user->id.'|old-remember-token|'.$guard->hashPasswordForCookie($user->password);
        $user->forceFill(['password' => Hash::make(self::NEW_PASSWORD), 'remember_token' => 'new-remember-token'])->save();
        $this->withCookie($guard->getRecallerName(), $oldCookie)
            ->post('/test-password-login', ['email' => $user->email, 'password' => self::NEW_PASSWORD, 'remember' => true])
            ->assertRedirect('/admin/ubah-password');
        $this->assertSame($guard->hashPasswordForCookie($user->password), session('password_hash_web'));
        $this->get('/admin/ubah-password')->assertOk();
    }

    #[DataProvider('rememberCookies')]
    public function test_remember_login_requires_both_current_token_and_password_fingerprint(string $type, int $status): void
    {
        $user = $this->user();
        $guard = Auth::guard();
        $cookie = $user->id.'|'.($type === 'old-token' ? 'revoked-token' : $user->remember_token).'|'.
            ($type === 'old-hash' ? $guard->hashPasswordForCookie(Hash::make('Obsolete password')) : $guard->hashPasswordForCookie($user->password));
        $this->withCookie($guard->getRecallerName(), $cookie)->get('/admin/ubah-password')->assertStatus($status);
        if ($status === 200) {
            $this->assertAuthenticatedAs($user);
            $this->assertSame($guard->hashPasswordForCookie($user->password), session('password_hash_web'));
        } else {
            $this->assertGuest();
        }
    }

    public function test_guest_cannot_open_page(): void
    {
        $this->get('/admin/ubah-password')->assertRedirect('/admin/login');
    }

    private function user(string $role = 'fap'): User
    {
        return User::factory()->create(['role' => $role, 'password' => Hash::make(self::OLD_PASSWORD), 'remember_token' => 'old-remember-token']);
    }

    private function authenticate(User $user): void
    {
        $this->actingAs($user)->withSession(['password_hash_web' => Auth::guard()->hashPasswordForCookie($user->password)]);
    }

    private function passwordData(string $new = self::NEW_PASSWORD): array
    {
        return ['current_password' => self::OLD_PASSWORD, 'password' => $new, 'password_confirmation' => $new];
    }

    private function insertSession(string $id, User $user): void
    {
        DB::table('sessions')->insert(['id' => $id, 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    }

    private function registerLoginRoute(): void
    {
        Route::middleware('web')->post('/test-password-login', function (Request $request) {
            if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                return response()->json(['error' => 'Login gagal.'], 422);
            }

            return redirect('/admin/ubah-password');
        });
    }

    public static function rememberCookies(): array
    {
        return [['valid', 200], ['old-token', 302], ['old-hash', 302]];
    }

    public static function legacyPasswords(): array
    {
        return [['old'], [str_repeat('a', 100)]];
    }

    private function assertStaleLivewire(callable $request): void
    {
        $handler = app(ExceptionHandler::class);
        $redirector = app('redirect');
        try {
            $this->assertThrows($request, AuthenticationException::class);
        } finally {
            app()->instance(ExceptionHandler::class, $handler);
            app()->instance('redirect', $redirector);
            unset(app()['middleware.disable']);
        }
        $this->assertGuest();
    }

    public static function roles(): array
    {
        return array_map(fn ($role) => [$role], ['admin', 'humas', 'fap', 'kepala_balai']);
    }

    public static function revokedAccounts(): array
    {
        return [['inactive'], ['invalid'], ['deleted']];
    }

    public static function invalidPasswords(): array
    {
        return [
            'current wrong' => [['current_password' => 'wrong'], 'current_password'],
            'short' => [['password' => 'short', 'password_confirmation' => 'short'], 'password'],
            'same' => [['password' => self::OLD_PASSWORD, 'password_confirmation' => self::OLD_PASSWORD], 'password'],
            'confirmation' => [['password_confirmation' => 'does not match'], 'password'],
            'bcrypt bytes' => [['password' => str_repeat('é', 37), 'password_confirmation' => str_repeat('é', 37)], 'password'],
            'null byte' => [['password' => "long password\0suffix", 'password_confirmation' => "long password\0suffix"], 'password'],
        ];
    }
}
