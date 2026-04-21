<?php

namespace App\Filament\Resources\SectionSipintus\Pages;

use App\Filament\Resources\SectionSipintus\SectionSipintuResource;
use Filament\Resources\Pages\EditRecord;

class EditSectionSipintu extends EditRecord
{
    protected static string $resource = SectionSipintuResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
