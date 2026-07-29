<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\SpmTkdnResource\Pages;

use App\Filament\Clusters\VerifikasiTkdn\Resources\SpmTkdnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmTkdns extends ListRecords
{
    protected static string $resource = SpmTkdnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
