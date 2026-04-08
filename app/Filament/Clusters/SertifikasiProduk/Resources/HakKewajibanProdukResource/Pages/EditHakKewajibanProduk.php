<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\HakKewajibanProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\HakKewajibanProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHakKewajibanProduk extends EditRecord
{
    protected static string $resource = HakKewajibanProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
