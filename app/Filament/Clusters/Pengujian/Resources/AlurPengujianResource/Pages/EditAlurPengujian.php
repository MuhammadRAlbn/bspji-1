<?php

namespace App\Filament\Clusters\Pengujian\Resources\AlurPengujianResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\AlurPengujianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlurPengujian extends EditRecord
{
    protected static string $resource = AlurPengujianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
