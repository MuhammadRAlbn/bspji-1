<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSdmSertifikasiProduk extends EditRecord
{
    protected static string $resource = SdmSertifikasiProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
