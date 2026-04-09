<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLphTarif extends EditRecord
{
    protected static string $resource = LphTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
