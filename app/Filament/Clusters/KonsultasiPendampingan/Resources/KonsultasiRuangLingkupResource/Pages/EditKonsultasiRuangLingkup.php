<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKonsultasiRuangLingkup extends EditRecord
{
    protected static string $resource = KonsultasiRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
