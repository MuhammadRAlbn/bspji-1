<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SertifikatProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\SertifikatProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSertifikatProduk extends EditRecord
{
    protected static string $resource = SertifikatProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
