<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpmKonsultasiPendampingans extends ListRecords
{
    protected static string $resource = SpmKonsultasiPendampinganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
