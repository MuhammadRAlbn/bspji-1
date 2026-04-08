<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInformasiPublikProduk extends EditRecord
{
    protected static string $resource = InformasiPublikProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
