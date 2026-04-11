<?php

namespace App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Pages;

use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSaranaPrasaranas extends ListRecords
{
    protected static string $resource = SaranaPrasaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
