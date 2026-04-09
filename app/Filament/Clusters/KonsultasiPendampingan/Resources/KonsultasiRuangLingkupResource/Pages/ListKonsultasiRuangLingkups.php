<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKonsultasiRuangLingkups extends ListRecords
{
    protected static string $resource = KonsultasiRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
