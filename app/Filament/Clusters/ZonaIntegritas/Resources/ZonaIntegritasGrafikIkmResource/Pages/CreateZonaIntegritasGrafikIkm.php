<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource;
use Filament\Resources\Pages\CreateRecord;

class CreateZonaIntegritasGrafikIkm extends CreateRecord
{
    protected static string $resource = ZonaIntegritasGrafikIkmResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
