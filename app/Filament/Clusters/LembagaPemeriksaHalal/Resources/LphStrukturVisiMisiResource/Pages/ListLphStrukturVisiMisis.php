<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLphStrukturVisiMisis extends ListRecords
{
    protected static string $resource = LphStrukturVisiMisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah data'),
        ];
    }
}
