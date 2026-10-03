<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource;
use App\Filament\Concerns\RechecksPanelAccess;
use Filament\Resources\Pages\ViewRecord;

class ViewRiwayatPenghapusanPengaduan extends ViewRecord
{
    use RechecksPanelAccess;

    protected static string $resource = RiwayatPenghapusanPengaduanResource::class;

    protected static ?string $title = 'Lihat Riwayat Penghapusan';
}
