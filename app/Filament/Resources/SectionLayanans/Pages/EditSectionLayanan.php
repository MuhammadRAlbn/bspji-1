<?php

namespace App\Filament\Resources\SectionLayanans\Pages;

use App\Filament\Resources\SectionLayanans\SectionLayananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSectionLayanan extends EditRecord
{
    protected static string $resource = SectionLayananResource::class;

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
