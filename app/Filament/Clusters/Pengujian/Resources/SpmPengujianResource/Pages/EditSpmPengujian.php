<?php

namespace App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmPengujian extends EditRecord
{
    protected static string $resource = SpmPengujianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
