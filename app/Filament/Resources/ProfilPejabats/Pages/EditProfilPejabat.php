<?php

namespace App\Filament\Resources\ProfilPejabats\Pages;

use App\Filament\Resources\ProfilPejabats\ProfilPejabatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProfilPejabat extends EditRecord
{
    protected static string $resource = ProfilPejabatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
