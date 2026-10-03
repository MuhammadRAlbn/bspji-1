<?php

namespace App\Filament\Pages;

use App\Exceptions\PasswordChangeThrottled;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use App\Filament\Concerns\ReportsFormValidationErrors;
use App\Models\User;
use App\Services\AccountSessionService;
use App\Services\UserPasswordService;
use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;

class ChangePassword extends EditProfile
{
    use ReportsFormValidationErrors;

    protected static ?string $title = 'Ubah Password';

    protected static ?string $slug = 'ubah-password';

    public function mount(): void
    {
        $this->checkSession();
        parent::mount();
    }

    public function hydrate(): void
    {
        $this->checkSession();
    }

    protected function fillForm(): void
    {
        $this->form->fill(['current_password' => null, 'password' => null, 'password_confirmation' => null]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('current_password')->label('Password Saat Ini')->password()->revealable()
                ->autocomplete('current-password')->required(),
            TextInput::make('password')->label('Password Baru')->password()->revealable()
                ->autocomplete('new-password')->required()->minLength(12)->confirmed()
                ->helperText('Minimal 12 karakter. Untuk bcrypt maksimal 72 byte; spasi diperbolehkan.'),
            TextInput::make('password_confirmation')->label('Konfirmasi Password Baru')->password()->revealable()
                ->autocomplete('new-password')->required(),
        ]);
    }

    public function save(): void
    {
        $user = $this->checkSession();
        try {
            $this->withFormValidation(fn () => app(UserPasswordService::class)->change($user, $this->data ?? [], request()->ip() ?? 'unknown'));
        } catch (PasswordChangeThrottled $exception) {
            Notification::make()->warning()->title('Terlalu banyak percobaan.')
                ->body('Coba lagi dalam '.$exception->seconds.' detik.')->send();

            return;
        }

        $this->resetValidation();
        $this->fillForm();
        Notification::make()->success()->title('Password berhasil diubah.')->send();
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')->label('Simpan Password')->submit('save');
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('back')->label('Kembali')->color('gray')
            ->url(Filament::auth()->user()->isPengaduanStaff() ? ZonaIntegritasPengaduanResource::getUrl('index') : Dashboard::getUrl());
    }

    private function checkSession(): User
    {
        return app(AccountSessionService::class)->ensureCurrent(Filament::auth()->user(), Filament::getAuthGuard());
    }
}
