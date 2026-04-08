<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLphAlurDanKelengkapan extends EditRecord
{
    protected static string $resource = LphAlurDanKelengkapanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
