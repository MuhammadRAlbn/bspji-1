<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\AlurKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\AlurKalibrasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlurKalibrasi extends EditRecord
{
    protected static string $resource = AlurKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
