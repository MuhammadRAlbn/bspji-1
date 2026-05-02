<?php

namespace App\Filament\Clusters\Pengujian\Resources\KomoditiResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\KomoditiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKomoditis extends ListRecords
{
    protected static string $resource = KomoditiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
