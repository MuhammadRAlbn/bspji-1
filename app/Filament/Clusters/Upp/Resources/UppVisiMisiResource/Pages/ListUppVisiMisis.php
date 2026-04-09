<?php

namespace App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Pages;

use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUppVisiMisis extends ListRecords
{
    protected static string $resource = UppVisiMisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
