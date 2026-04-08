<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\HakKewajibanProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\HakKewajibanProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHakKewajibanProduks extends ListRecords
{
    protected static string $resource = HakKewajibanProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
