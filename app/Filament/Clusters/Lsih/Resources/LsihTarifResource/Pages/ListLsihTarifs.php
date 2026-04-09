<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihTarifResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihTarifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLsihTarifs extends ListRecords
{
    protected static string $resource = LsihTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => LsihTarifResource::getModel()::count() === 0),
        ];
    }
}
