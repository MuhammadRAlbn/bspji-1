<?php

namespace App\Filament\Resources\SectionTestimonis\Pages;

use App\Filament\Resources\SectionTestimonis\SectionTestimoniResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSectionTestimoni extends EditRecord
{
    protected static string $resource = SectionTestimoniResource::class;

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
