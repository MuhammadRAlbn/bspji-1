<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Pages;

use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPelatihanTeknisAlur extends EditRecord
{
    protected static string $resource = PelatihanTeknisAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
