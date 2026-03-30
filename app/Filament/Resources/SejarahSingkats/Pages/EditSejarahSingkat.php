<?php

namespace App\Filament\Resources\SejarahSingkats\Pages;

use App\Filament\Resources\SejarahSingkats\SejarahSingkatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSejarahSingkat extends EditRecord
{
    protected static string $resource = SejarahSingkatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
