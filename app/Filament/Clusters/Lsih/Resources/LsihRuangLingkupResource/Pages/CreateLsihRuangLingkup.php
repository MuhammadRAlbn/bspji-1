<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLsihRuangLingkup extends CreateRecord
{
    protected static string $resource = LsihRuangLingkupResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
