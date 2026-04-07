<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\DokumenProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\DokumenProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDokumenProduk extends EditRecord
{
    protected static string $resource = DokumenProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
