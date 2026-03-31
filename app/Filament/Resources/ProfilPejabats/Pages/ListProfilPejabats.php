<?php

namespace App\Filament\Resources\ProfilPejabats\Pages;

use App\Filament\Resources\ProfilPejabats\ProfilPejabatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProfilPejabats extends ListRecords
{
    protected static string $resource = ProfilPejabatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
