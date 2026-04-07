<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\AlurProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\AlurProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlurProduks extends ListRecords
{
    protected static string $resource = AlurProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
