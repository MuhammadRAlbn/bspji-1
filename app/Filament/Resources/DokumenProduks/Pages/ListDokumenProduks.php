<?php

namespace App\Filament\Resources\DokumenProduks\Pages;

use App\Filament\Resources\DokumenProduks\DokumenProdukResource;
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
