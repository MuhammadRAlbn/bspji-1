<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Pages;

use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\DetailInformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDetailInformasis extends ListRecords
{
    protected static string $resource = DetailInformasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),
            'berkala' => Tab::make('Informasi Berkala')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('tipe', 'berkala')),
            'setiap_saat' => Tab::make('Informasi Setiap Saat')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('tipe', 'setiap_saat')),
        ];
    }
}
