<?php

namespace App\Filament\Resources\SectionTestimonis\Pages;

use App\Filament\Resources\SectionTestimonis\SectionTestimoniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSectionTestimonis extends ListRecords
{
    protected static string $resource = SectionTestimoniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
