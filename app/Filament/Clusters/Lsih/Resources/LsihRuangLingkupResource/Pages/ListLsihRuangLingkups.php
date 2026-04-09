<?php

namespace App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource\Pages;

use App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLsihRuangLingkups extends ListRecords
{
    protected static string $resource = LsihRuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => LsihRuangLingkupResource::getModel()::count() === 0),
        ];
    }
}
