<?php

namespace App\Filament\Resources\Users\Actions;

use App\Models\User;
use App\Services\UserManagementService;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;

class DeleteUserAction extends DeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Hapus')
            ->hidden(fn (?User $record): bool => $record === null)
            ->modalHeading('Hapus Akun')
            ->modalDescription(fn (User $record): string => "Hapus akun {$record->name} ({$record->email})? Penghapusan permanen tidak dapat dibatalkan.")
            ->modalSubmitActionLabel('Hapus Akun')
            ->successNotificationTitle('Akun berhasil dihapus')
            ->using(fn (User $record): bool => app(UserManagementService::class)->delete(Filament::auth()->user(), $record));
    }
}
