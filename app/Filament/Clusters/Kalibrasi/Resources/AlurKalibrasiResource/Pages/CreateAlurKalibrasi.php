<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\AlurKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\AlurKalibrasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlurKalibrasi extends CreateRecord
{
    protected static string $resource = AlurKalibrasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
