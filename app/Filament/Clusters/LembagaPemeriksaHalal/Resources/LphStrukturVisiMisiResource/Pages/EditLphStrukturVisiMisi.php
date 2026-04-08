<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLphStrukturVisiMisi extends EditRecord
{
    protected static string $resource = LphStrukturVisiMisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
