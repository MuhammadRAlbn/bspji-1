<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Pages;

use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPelatihanTeknisRuangLingkup extends EditRecord
{
    protected static string $resource = PelatihanTeknisRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
