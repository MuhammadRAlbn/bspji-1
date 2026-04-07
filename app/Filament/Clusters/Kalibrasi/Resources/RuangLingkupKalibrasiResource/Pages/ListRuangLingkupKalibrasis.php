<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\RuangLingkupKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\RuangLingkupKalibrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRuangLingkupKalibrasis extends ListRecords
{
    protected static string $resource = RuangLingkupKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
