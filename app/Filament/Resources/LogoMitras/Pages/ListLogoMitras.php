<?php

namespace App\Filament\Resources\LogoMitras\Pages;

use App\Filament\Resources\LogoMitras\LogoMitraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogoMitras extends ListRecords
{
    protected static string $resource = LogoMitraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
