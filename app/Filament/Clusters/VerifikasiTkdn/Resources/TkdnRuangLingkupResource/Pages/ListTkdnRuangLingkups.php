<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Pages;

use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTkdnRuangLingkups extends ListRecords
{
    protected static string $resource = TkdnRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => TkdnRuangLingkupResource::getModel()::count() === 0),
        ];
    }
}
