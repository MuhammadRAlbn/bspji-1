<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLphTarifs extends ListRecords
{
    protected static string $resource = LphTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
