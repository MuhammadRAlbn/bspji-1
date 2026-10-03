<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource;
use App\Filament\Concerns\RechecksPanelAccess;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPenghapusanPengaduans extends ListRecords
{
    use RechecksPanelAccess;

    protected static string $resource = RiwayatPenghapusanPengaduanResource::class;
}
