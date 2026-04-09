<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihTarifResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihTarifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLsihTarif extends EditRecord
{
    protected static string $resource = LsihTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
