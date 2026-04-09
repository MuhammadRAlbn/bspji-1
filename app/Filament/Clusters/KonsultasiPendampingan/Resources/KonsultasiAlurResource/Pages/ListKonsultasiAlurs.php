<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKonsultasiAlurs extends ListRecords
{
    protected static string $resource = KonsultasiAlurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
