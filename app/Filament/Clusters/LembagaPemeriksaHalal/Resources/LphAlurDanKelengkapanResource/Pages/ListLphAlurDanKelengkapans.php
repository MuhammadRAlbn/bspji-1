<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLphAlurDanKelengkapans extends ListRecords
{
    protected static string $resource = LphAlurDanKelengkapanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah data'),
        ];
    }
}
