<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditZonaIntegritasDokumen extends EditRecord
{
    protected static string $resource = ZonaIntegritasDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
