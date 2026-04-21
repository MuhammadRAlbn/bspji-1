<?php

namespace App\Filament\Resources\SectionProfils\Pages;

use App\Filament\Resources\SectionProfils\SectionProfilResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSectionProfil extends CreateRecord
{
    protected static string $resource = SectionProfilResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
