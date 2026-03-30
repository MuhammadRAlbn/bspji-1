<?php

namespace App\Filament\Resources\SejarahSingkats\Pages;

use App\Filament\Resources\SejarahSingkats\SejarahSingkatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSejarahSingkat extends CreateRecord
{
    protected static string $resource = SejarahSingkatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
