<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\RuangLingkupKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\RuangLingkupKalibrasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRuangLingkupKalibrasi extends EditRecord
{
    protected static string $resource = RuangLingkupKalibrasiResource::class;

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
