<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\AlurProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\AlurProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlurProduk extends EditRecord
{
    protected static string $resource = AlurProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
