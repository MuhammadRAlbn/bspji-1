<?php

namespace App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Pages;

use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUppSopFormulirs extends ListRecords
{
    protected static string $resource = UppSopFormulirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
