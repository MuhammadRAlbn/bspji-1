<?php

namespace App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Pages;

use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUppMaklumatPelayanans extends ListRecords
{
    protected static string $resource = UppMaklumatPelayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
