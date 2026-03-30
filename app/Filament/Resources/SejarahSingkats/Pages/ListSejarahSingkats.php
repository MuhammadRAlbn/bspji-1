<?php

namespace App\Filament\Resources\SejarahSingkats\Pages;

use App\Filament\Resources\SejarahSingkats\SejarahSingkatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSejarahSingkats extends ListRecords
{
    protected static string $resource = SejarahSingkatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
