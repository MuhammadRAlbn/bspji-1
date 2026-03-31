<?php

namespace App\Filament\Resources\ProfilPejabats\Pages;

use App\Filament\Resources\ProfilPejabats\ProfilPejabatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProfilPejabat extends CreateRecord
{
    protected static string $resource = ProfilPejabatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
