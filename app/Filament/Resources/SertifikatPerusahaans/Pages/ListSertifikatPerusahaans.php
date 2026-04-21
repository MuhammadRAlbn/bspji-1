<?php

namespace App\Filament\Resources\SertifikatPerusahaans\Pages;

use App\Filament\Resources\SertifikatPerusahaans\SertifikatPerusahaanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSertifikatPerusahaans extends ListRecords
{
    protected static string $resource = SertifikatPerusahaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
