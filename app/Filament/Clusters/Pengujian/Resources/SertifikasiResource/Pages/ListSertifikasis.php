<?php

namespace App\Filament\Clusters\Pengujian\Resources\SertifikasiResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\SertifikasiResource;
use Filament\Resources\Pages\ListRecords;

class ListSertifikasis extends ListRecords
{
    protected static string $resource = SertifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
