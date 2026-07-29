<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\SpmTkdnResource\Pages;

use App\Filament\Clusters\VerifikasiTkdn\Resources\SpmTkdnResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmTkdn extends EditRecord
{
    protected static string $resource = SpmTkdnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
