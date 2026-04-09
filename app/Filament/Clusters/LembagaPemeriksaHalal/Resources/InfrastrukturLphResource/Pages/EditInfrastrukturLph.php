<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Pages;

use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInfrastrukturLph extends EditRecord
{
    protected static string $resource = InfrastrukturLphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
