<?php

namespace App\Filament\Clusters\Pengujian\Resources\RuangLingkupResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\RuangLingkupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRuangLingkup extends EditRecord
{
    protected static string $resource = RuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
