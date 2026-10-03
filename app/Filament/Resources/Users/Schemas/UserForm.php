<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Pages\ChangePassword;
use App\Models\User;
use App\Rules\PasswordWithinHashLimit;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama')->required()->maxLength(255),
            TextInput::make('email')->label('Email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
            Select::make('role')->label('Role')->options(User::roleOptions())
                ->rules([Rule::in(User::panelRoles())])->required()->native(false)->live(),
            Toggle::make('is_active')->label('Akun Aktif')->default(true)
                ->helperText('Akun nonaktif tidak dapat mengakses panel admin atau bukti pengaduan.'),
            TextEntry::make('izin_akses')->label('Izin Akses')
                ->state(fn (Get $get): string => User::roleDescription($get('role')))->columnSpanFull(),
            TextEntry::make('ubah_password_sendiri')->label('Password Akun Anda')
                ->state('Ubah Password')->url(fn (): string => ChangePassword::getUrl())
                ->visible(fn (?User $record): bool => $record?->is(Filament::auth()->user()) ?? false)
                ->helperText('Verifikasi password saat ini melalui menu Ubah Password.'),
            TextInput::make('password')->label('Password')->password()->revealable()
                ->hidden(fn (?User $record): bool => $record?->is(Filament::auth()->user()) ?? false)
                ->autocomplete('new-password')->formatStateUsing(fn (): ?string => null)
                ->required(fn (string $operation): bool => $operation === 'create')->minLength(12)->confirmed()
                ->rules([new PasswordWithinHashLimit])
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->helperText('Minimal 12 karakter, maksimal 72 byte untuk bcrypt. Saat edit, kosongkan untuk mempertahankan password lama.'),
            TextInput::make('password_confirmation')->label('Konfirmasi Password')->password()->revealable()
                ->hidden(fn (?User $record): bool => $record?->is(Filament::auth()->user()) ?? false)
                ->autocomplete('new-password')->required(fn (Get $get): bool => filled($get('password')))
                ->dehydrated(fn (Get $get): bool => filled($get('password'))),
        ]);
    }
}
