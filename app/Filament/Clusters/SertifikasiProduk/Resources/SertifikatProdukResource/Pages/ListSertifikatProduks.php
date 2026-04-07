<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SertifikatProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\SertifikatProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSertifikatProduks extends ListRecords
{
    protected static string $resource = SertifikatProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
