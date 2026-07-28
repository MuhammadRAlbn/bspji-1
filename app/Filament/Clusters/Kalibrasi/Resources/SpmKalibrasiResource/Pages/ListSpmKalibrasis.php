<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\SpmKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\SpmKalibrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmKalibrasis extends ListRecords
{
    protected static string $resource = SpmKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
