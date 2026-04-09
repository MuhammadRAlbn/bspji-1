<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonsultasiTarif extends EditRecord
{
    protected static string $resource = KonsultasiTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
