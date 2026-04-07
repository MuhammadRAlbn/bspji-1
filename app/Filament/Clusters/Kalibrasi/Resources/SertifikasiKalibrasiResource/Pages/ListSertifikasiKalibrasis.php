<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSertifikasiKalibrasis extends ListRecords
{
    protected static string $resource = SertifikasiKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
