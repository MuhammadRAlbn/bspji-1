<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\RuangLingkupKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\RuangLingkupKalibrasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRuangLingkupKalibrasi extends CreateRecord
{
    protected static string $resource = RuangLingkupKalibrasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
