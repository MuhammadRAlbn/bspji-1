<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Pages;

use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource;
use App\Models\KonsultasiTarif;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonsultasiTarifs extends ListRecords
{
    protected static string $resource = KonsultasiTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => KonsultasiTarif::count() === 0),
        ];
    }
}
