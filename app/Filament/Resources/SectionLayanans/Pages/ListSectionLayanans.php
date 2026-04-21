<?php

namespace App\Filament\Resources\SectionLayanans\Pages;

use App\Filament\Resources\SectionLayanans\SectionLayananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSectionLayanans extends ListRecords
{
    protected static string $resource = SectionLayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
