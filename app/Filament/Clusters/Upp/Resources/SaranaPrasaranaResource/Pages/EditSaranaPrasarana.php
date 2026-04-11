<?php

namespace App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Pages;

use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSaranaPrasarana extends EditRecord
{
    protected static string $resource = SaranaPrasaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
