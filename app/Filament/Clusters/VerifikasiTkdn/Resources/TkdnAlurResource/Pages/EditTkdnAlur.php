<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Pages;

use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTkdnAlur extends EditRecord
{
    protected static string $resource = TkdnAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
