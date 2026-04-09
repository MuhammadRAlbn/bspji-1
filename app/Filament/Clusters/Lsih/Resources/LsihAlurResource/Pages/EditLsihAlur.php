<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihAlurResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihAlurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLsihAlur extends EditRecord
{
    protected static string $resource = LsihAlurResource::class;

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
