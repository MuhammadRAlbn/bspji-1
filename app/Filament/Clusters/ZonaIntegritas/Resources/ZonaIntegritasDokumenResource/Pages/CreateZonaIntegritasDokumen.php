<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateZonaIntegritasDokumen extends CreateRecord
{
    protected static string $resource = ZonaIntegritasDokumenResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
