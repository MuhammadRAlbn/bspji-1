<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SpmLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SpmLphResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmLph extends EditRecord
{
    protected static string $resource = SpmLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
