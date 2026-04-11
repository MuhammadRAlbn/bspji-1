<?php

namespace App\Filament\Clusters\Upp\Resources\SkSpmResource\Pages;

use App\Filament\Clusters\Upp\Resources\SkSpmResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSkSpm extends EditRecord
{
    protected static string $resource = SkSpmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
