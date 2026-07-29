<?php

namespace App\Filament\Clusters\Lsih\Resources\SpmLsihResource\Pages;

use App\Filament\Clusters\Lsih\Resources\SpmLsihResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpmLsih extends EditRecord
{
    protected static string $resource = SpmLsihResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
