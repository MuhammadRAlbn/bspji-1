<?php

namespace App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Pages;

use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUppVisiMisi extends EditRecord
{
    protected static string $resource = UppVisiMisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
