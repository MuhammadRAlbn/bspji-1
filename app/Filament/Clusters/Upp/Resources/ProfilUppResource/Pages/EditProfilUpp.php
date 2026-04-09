<?php

namespace App\Filament\Clusters\Upp\Resources\ProfilUppResource\Pages;

use App\Filament\Clusters\Upp\Resources\ProfilUppResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProfilUpp extends EditRecord
{
    protected static string $resource = ProfilUppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
