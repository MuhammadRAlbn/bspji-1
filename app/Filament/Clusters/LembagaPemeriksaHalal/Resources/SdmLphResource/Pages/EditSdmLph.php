<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSdmLph extends EditRecord
{
    protected static string $resource = SdmLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
