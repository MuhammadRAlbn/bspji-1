<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources;

use App\Filament\Clusters\KonsultasiPendampingan\KonsultasiPendampinganCluster;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Pages\CreateKonsultasiTarif;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Pages\EditKonsultasiTarif;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Pages\ListKonsultasiTarifs;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Schemas\KonsultasiTarifForm;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Tables\KonsultasiTarifsTable;
use App\Models\KonsultasiTarif;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KonsultasiTarifResource extends Resource
{
    protected static ?string $cluster = KonsultasiPendampinganCluster::class;

    protected static ?string $model = KonsultasiTarif::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $navigationLabel = 'Tarif';

    protected static ?string $pluralLabel = 'Tarif';

    protected static ?string $modelLabel = 'Tarif';

    public static function form(Schema $schema): Schema
    {
        return KonsultasiTarifForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KonsultasiTarifsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKonsultasiTarifs::route('/'),
            'create' => CreateKonsultasiTarif::route('/create'),
            'edit' => EditKonsultasiTarif::route('/{record}/edit'),
        ];
    }
}
