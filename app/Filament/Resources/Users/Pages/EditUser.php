<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Concerns\RechecksPanelAccess;
use App\Filament\Concerns\ReportsFormValidationErrors;
use App\Filament\Resources\Users\Actions\DeleteUserAction;
use App\Filament\Resources\Users\UserResource;
use App\Services\UserManagementService;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    use RechecksPanelAccess, ReportsFormValidationErrors;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteUserAction::make()];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return $this->withFormValidation(fn (): Model => app(UserManagementService::class)->update(Filament::auth()->user(), $record, $data));
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
