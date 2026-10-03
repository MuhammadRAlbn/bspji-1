<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use App\Filament\Concerns\RechecksPanelAccess;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewZonaIntegritasPengaduan extends ViewRecord
{
    use RechecksPanelAccess;

    protected static string $resource = ZonaIntegritasPengaduanResource::class;

    protected static ?string $title = 'Lihat Pengaduan';

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
