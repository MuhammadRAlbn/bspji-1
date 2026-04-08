<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLphKebijakanSasaranMutu extends EditRecord
{
    protected static string $resource = LphKebijakanSasaranMutuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
