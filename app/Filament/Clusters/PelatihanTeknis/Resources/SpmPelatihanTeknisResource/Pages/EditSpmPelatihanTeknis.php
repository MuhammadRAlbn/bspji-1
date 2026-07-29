<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource\Pages;

use App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmPelatihanTeknis extends EditRecord
{
    protected static string $resource = SpmPelatihanTeknisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
