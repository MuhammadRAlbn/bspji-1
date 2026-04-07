<?php

namespace App\Filament\Resources\DokumenProduks\Pages;

use App\Filament\Resources\DokumenProduks\DokumenProdukResource;
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
