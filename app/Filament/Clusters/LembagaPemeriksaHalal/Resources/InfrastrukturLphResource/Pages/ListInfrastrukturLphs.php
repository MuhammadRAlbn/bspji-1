<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfrastrukturLphs extends ListRecords
{
    protected static string $resource = InfrastrukturLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
