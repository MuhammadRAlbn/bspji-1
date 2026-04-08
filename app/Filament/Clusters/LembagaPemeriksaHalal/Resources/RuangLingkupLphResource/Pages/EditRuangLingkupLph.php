<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRuangLingkupLph extends EditRecord
{
    protected static string $resource = RuangLingkupLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
