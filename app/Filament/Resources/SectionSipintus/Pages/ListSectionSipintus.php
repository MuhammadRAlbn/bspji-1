<?php

namespace App\Filament\Resources\SectionSipintus\Pages;

use App\Filament\Resources\SectionSipintus\SectionSipintuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSectionSipintus extends ListRecords
{
    protected static string $resource = SectionSipintuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => ! SectionSipintuResource::getModel()::query()->exists()),
        ];
    }
}
