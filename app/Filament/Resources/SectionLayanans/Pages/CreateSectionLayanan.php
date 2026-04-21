<?php

namespace App\Filament\Resources\SectionLayanans\Pages;

use App\Filament\Resources\SectionLayanans\SectionLayananResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSectionLayanan extends CreateRecord
{
    protected static string $resource = SectionLayananResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
