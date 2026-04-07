<?php

namespace App\Filament\Clusters\Pengujian\Resources\AlurPengujianResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\AlurPengujianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlurPengujians extends ListRecords
{
    protected static string $resource = AlurPengujianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
