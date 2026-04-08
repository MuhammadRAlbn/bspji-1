<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInformasiPublikProduks extends ListRecords
{
    protected static string $resource = InformasiPublikProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
