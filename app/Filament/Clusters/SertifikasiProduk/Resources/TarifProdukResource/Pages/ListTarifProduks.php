<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\TarifProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\TarifProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTarifProduks extends ListRecords
{
    protected static string $resource = TarifProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
