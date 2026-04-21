<?php

namespace App\Filament\Resources\SertifikatPerusahaans\Pages;

use App\Filament\Resources\SertifikatPerusahaans\SertifikatPerusahaanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSertifikatPerusahaan extends CreateRecord
{
    protected static string $resource = SertifikatPerusahaanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
