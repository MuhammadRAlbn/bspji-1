<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\AlurKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\AlurKalibrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlurKalibrasis extends ListRecords
{
    protected static string $resource = AlurKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
