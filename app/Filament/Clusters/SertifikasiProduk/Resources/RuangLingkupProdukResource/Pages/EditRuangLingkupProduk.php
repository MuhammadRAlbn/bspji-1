<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\RuangLingkupProdukResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\RuangLingkupProdukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRuangLingkupProduk extends EditRecord
{
    protected static string $resource = RuangLingkupProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
