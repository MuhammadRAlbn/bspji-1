<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Pages;

use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTkdnAlurs extends ListRecords
{
    protected static string $resource = TkdnAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => TkdnAlurResource::getModel()::count() === 0),
        ];
    }
}
