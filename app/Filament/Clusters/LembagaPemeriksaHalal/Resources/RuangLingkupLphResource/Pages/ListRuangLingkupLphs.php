<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRuangLingkupLphs extends ListRecords
{
    protected static string $resource = RuangLingkupLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
