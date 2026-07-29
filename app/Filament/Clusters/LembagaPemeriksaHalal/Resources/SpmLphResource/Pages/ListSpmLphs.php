<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SpmLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SpmLphResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmLphs extends ListRecords
{
    protected static string $resource = SpmLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
