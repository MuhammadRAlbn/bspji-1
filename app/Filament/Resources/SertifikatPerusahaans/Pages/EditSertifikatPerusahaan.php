<?php

namespace App\Filament\Resources\SertifikatPerusahaans\Pages;

use App\Filament\Resources\SertifikatPerusahaans\SertifikatPerusahaanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSertifikatPerusahaan extends EditRecord
{
    protected static string $resource = SertifikatPerusahaanResource::class;

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
