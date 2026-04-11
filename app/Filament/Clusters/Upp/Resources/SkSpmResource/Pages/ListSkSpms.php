<?php

namespace App\Filament\Clusters\Upp\Resources\SkSpmResource\Pages;

use App\Filament\Clusters\Upp\Resources\SkSpmResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSkSpms extends ListRecords
{
    protected static string $resource = SkSpmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
