<?php

namespace App\Filament\Resources\LogoMitras\Pages;

use App\Filament\Resources\LogoMitras\LogoMitraResource;
use App\Models\LogoMitra;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLogoMitra extends EditRecord
{
    protected static string $resource = LogoMitraResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['singleton_key'] = $this->record->tipe === LogoMitra::TYPE_PELENGKAP ? 'pelengkap' : null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => $this->record->tipe === LogoMitra::TYPE_LOGO),
        ];
    }
}
