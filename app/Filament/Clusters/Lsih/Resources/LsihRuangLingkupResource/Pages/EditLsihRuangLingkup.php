<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLsihRuangLingkup extends EditRecord
{
    protected static string $resource = LsihRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
