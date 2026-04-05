<?php

namespace App\Filament\Clusters\Pengujian\Resources\SertifikasiResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\SertifikasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSertifikasi extends EditRecord
{
    protected static string $resource = SertifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
