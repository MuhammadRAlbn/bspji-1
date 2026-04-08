<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Pages\CreateSdmLph;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Pages\EditSdmLph;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Pages\ListSdmLphs;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Schemas\SdmLphForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Tables\SdmLphsTable;
use App\Models\SdmLph;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SdmLphResource extends Resource
{
    protected static ?string $model = SdmLph::class;

    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SdmLphForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SdmLphsTable::configure($table);
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
            'index' => ListSdmLphs::route('/'),
            'create' => CreateSdmLph::route('/create'),
            'edit' => EditSdmLph::route('/{record}/edit'),
        ];
    }
}
