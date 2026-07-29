<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmSertifikasiProduks extends ListRecords
{
    protected static string $resource = SpmSertifikasiProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
