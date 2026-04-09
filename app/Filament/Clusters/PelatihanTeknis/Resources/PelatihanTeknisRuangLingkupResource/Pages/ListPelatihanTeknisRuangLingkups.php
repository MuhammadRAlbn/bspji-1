<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Pages;

use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPelatihanTeknisRuangLingkups extends ListRecords
{
    protected static string $resource = PelatihanTeknisRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => PelatihanTeknisRuangLingkupResource::getModel()::count() === 0),
        ];
    }
}
