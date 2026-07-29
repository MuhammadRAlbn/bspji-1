<?php

namespace App\Filament\Clusters\Lsih\Resources\SpmLsihResource\Pages;

use App\Filament\Clusters\Lsih\Resources\SpmLsihResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmLsihs extends ListRecords
{
    protected static string $resource = SpmLsihResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
