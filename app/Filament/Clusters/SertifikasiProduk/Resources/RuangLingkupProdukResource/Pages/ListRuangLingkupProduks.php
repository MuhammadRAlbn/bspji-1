<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\RuangLingkupProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\RuangLingkupProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRuangLingkupProduks extends ListRecords
{
    protected static string $resource = RuangLingkupProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
