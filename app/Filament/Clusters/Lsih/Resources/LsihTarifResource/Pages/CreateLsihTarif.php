<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihTarifResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihTarifResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLsihTarif extends CreateRecord
{
    protected static string $resource = LsihTarifResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
