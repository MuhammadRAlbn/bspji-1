<?php

namespace App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Pages;

use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUppSopFormulir extends EditRecord
{
    protected static string $resource = UppSopFormulirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
