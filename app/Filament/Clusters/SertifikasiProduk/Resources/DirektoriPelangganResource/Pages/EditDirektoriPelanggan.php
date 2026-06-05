<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Pages;

use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDirektoriPelanggan extends EditRecord
{
    protected static string $resource = DirektoriPelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
