<?php

namespace App\Filament\Resources\SectionSipintus\Pages;

use App\Filament\Resources\SectionSipintus\SectionSipintuResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSectionSipintu extends CreateRecord
{
    protected static string $resource = SectionSipintuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['singleton_key'] = 'default';

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
