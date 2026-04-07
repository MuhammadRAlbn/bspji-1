<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\DokumenProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\DokumenProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDokumenProduks extends ListRecords
{
    protected static string $resource = DokumenProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
