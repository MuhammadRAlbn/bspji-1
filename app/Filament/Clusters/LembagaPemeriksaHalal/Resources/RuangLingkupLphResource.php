<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Pages\CreateRuangLingkupLph;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Pages\EditRuangLingkupLph;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Pages\ListRuangLingkupLphs;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Schemas\RuangLingkupLphForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Tables\RuangLingkupLphsTable;
use App\Models\RuangLingkupLph;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RuangLingkupLphResource extends Resource
{
    protected static ?string $model = RuangLingkupLph::class;

    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RuangLingkupLphForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RuangLingkupLphsTable::configure($table);
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
            'index' => ListRuangLingkupLphs::route('/'),
            'create' => CreateRuangLingkupLph::route('/create'),
            'edit' => EditRuangLingkupLph::route('/{record}/edit'),
        ];
    }
}
