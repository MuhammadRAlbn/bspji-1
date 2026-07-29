<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmSertifikasiProduk extends EditRecord
{
    protected static string $resource = SpmSertifikasiProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
