<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSdmLphs extends ListRecords
{
    protected static string $resource = SdmLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
