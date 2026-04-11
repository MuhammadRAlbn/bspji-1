<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Pages;

use App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\DaftarInformasiPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDaftarInformasiPubliks extends ListRecords
{
    protected static string $resource = DaftarInformasiPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => DaftarInformasiPublikResource::getModel()::count() === 0),
        ];
    }
}
