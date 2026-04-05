<?php

namespace App\Filament\Clusters\Pengujian\Resources\RuangLingkupResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\RuangLingkupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRuangLingkups extends ListRecords
{
    protected static string $resource = RuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
