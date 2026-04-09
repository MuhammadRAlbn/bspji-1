<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihAlurResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihAlurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLsihAlurs extends ListRecords
{
    protected static string $resource = LsihAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => LsihAlurResource::getModel()::count() === 0),
        ];
    }
}
