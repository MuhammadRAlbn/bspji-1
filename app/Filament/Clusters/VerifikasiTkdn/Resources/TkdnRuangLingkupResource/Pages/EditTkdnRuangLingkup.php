<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Pages;

use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTkdnRuangLingkup extends EditRecord
{
    protected static string $resource = TkdnRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
