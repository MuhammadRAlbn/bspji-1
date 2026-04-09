<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihAlurResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihAlurResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLsihAlur extends CreateRecord
{
    protected static string $resource = LsihAlurResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
