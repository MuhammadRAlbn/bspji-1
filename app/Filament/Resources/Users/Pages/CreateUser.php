<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Concerns\RechecksPanelAccess;
use App\Filament\Concerns\ReportsFormValidationErrors;
use App\Filament\Resources\Users\UserResource;
use App\Services\UserManagementService;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    use RechecksPanelAccess, ReportsFormValidationErrors;

    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return $this->withFormValidation(fn (): Model => app(UserManagementService::class)->create(Filament::auth()->user(), $data));
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
