<?php

namespace App\Filament\Clusters\Pengujian\Resources\KomoditiResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\KomoditiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKomoditi extends EditRecord
{
    protected static string $resource = KomoditiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
