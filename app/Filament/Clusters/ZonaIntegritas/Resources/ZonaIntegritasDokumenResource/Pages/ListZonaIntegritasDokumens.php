<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListZonaIntegritasDokumens extends ListRecords
{
    protected static string $resource = ZonaIntegritasDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
