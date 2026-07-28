<?php

namespace App\Filament\Clusters\Kalibrasi\Resources\SpmKalibrasiResource\Pages;

use App\Filament\Clusters\Kalibrasi\Resources\SpmKalibrasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmKalibrasi extends EditRecord
{
    protected static string $resource = SpmKalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
