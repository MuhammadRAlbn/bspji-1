<?php

namespace App\Filament\Resources\SectionTestimonis\Pages;

use App\Filament\Resources\SectionTestimonis\SectionTestimoniResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSectionTestimoni extends CreateRecord
{
    protected static string $resource = SectionTestimoniResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
