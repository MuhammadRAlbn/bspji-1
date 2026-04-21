<?php

namespace App\Filament\Resources\SectionProfils\Pages;

use App\Filament\Resources\SectionProfils\SectionProfilResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSectionProfils extends ListRecords
{
    protected static string $resource = SectionProfilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => SectionProfilResource::getModel()::query()->count() < 3),
        ];
    }
}
