<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Pages;

use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\DetailInformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailInformasi extends EditRecord
{
    protected static string $resource = DetailInformasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
