<?php

namespace App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Pages;

use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUppMaklumatPelayanan extends EditRecord
{
    protected static string $resource = UppMaklumatPelayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
