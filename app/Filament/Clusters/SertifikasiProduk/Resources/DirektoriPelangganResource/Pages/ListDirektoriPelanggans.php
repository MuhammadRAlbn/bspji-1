<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDirektoriPelanggans extends ListRecords
{
    protected static string $resource = DirektoriPelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
