<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Pages;

use App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\PermohonanInformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermohonanInformasis extends ListRecords
{
    protected static string $resource = PermohonanInformasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => PermohonanInformasiResource::getModel()::count() === 0),
        ];
    }
}
