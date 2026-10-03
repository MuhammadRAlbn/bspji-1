<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Actions\DeletePengaduanAction;
use App\Filament\Concerns\RechecksPanelAccess;
use App\Filament\Concerns\ReportsFormValidationErrors;
use App\Services\ZonaIntegritasPengaduanFollowUpService;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditZonaIntegritasPengaduan extends EditRecord
{
    use RechecksPanelAccess, ReportsFormValidationErrors;

    protected static string $resource = ZonaIntegritasPengaduanResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return $this->withFormValidation(fn (): Model => app(ZonaIntegritasPengaduanFollowUpService::class)->update(Filament::auth()->user(), $record, $data));
    }

    protected function getHeaderActions(): array
    {
        return [
            DeletePengaduanAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
