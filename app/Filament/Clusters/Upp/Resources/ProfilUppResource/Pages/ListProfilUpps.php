<?php

namespace App\Filament\Clusters\Upp\Resources\ProfilUppResource\Pages;

use App\Filament\Clusters\Upp\Resources\ProfilUppResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProfilUpps extends ListRecords
{
    protected static string $resource = ProfilUppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => ProfilUppResource::getModel()::count() === 0),
        ];
    }
}
