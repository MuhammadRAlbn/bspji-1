<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmKonsultasiPendampingan extends EditRecord
{
    protected static string $resource = SpmKonsultasiPendampinganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
