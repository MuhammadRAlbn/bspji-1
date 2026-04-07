<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSertifikasiKalibrasi extends EditRecord
{
    protected static string $resource = SertifikasiKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
