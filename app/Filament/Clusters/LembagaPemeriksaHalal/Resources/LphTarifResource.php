<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Pages\CreateLphTarif;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Pages\EditLphTarif;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Pages\ListLphTarifs;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Schemas\LphTarifForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Tables\LphTarifsTable;
use App\Models\TarifHalal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LphTarifResource extends Resource
{
    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static ?string $model = TarifHalal::class;

    protected static ?string $navigationLabel = 'Tarif';

    protected static ?string $pluralLabel = 'Tarif';

    protected static ?string $modelLabel = 'Tarif';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    public static function form(Schema $schema): Schema
    {
        return LphTarifForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LphTarifsTable::configure($table);
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
            'index' => ListLphTarifs::route('/'),
            'create' => CreateLphTarif::route('/create'),
            'edit' => EditLphTarif::route('/{record}/edit'),
        ];
    }
}
