<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListZonaIntegritasGrafikIkms extends ListRecords
{
    protected static string $resource = ZonaIntegritasGrafikIkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
