<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSdmSertifikasiProduks extends ListRecords
{
    protected static string $resource = SdmSertifikasiProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
