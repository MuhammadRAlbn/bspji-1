<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource\Pages;

use App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmPelatihanTekniss extends ListRecords
{
    protected static string $resource = SpmPelatihanTeknisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
