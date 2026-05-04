<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditZonaIntegritasGrafikIkm extends EditRecord
{
    protected static string $resource = ZonaIntegritasGrafikIkmResource::class;

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
