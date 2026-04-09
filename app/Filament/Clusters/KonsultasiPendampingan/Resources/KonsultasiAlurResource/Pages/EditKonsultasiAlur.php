<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKonsultasiAlur extends EditRecord
{
    protected static string $resource = KonsultasiAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
