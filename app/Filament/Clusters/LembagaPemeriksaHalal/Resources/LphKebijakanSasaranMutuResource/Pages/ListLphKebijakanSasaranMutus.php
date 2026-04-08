<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLphKebijakanSasaranMutus extends ListRecords
{
    protected static string $resource = LphKebijakanSasaranMutuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah data'),
        ];
    }
}
