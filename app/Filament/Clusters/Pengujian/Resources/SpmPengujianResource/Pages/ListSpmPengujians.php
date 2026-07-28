<?php

namespace App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmPengujians extends ListRecords
{
    protected static string $resource = SpmPengujianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
