<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSertifikasiKalibrasi extends CreateRecord
{
    protected static string $resource = SertifikasiKalibrasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
