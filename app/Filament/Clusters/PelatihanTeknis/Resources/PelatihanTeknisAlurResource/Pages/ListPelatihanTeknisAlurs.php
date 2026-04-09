<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Pages;

use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPelatihanTeknisAlurs extends ListRecords
{
    protected static string $resource = PelatihanTeknisAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => PelatihanTeknisAlurResource::getModel()::count() === 0),
        ];
    }
}
