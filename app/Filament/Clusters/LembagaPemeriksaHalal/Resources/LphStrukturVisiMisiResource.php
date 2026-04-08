<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Pages\CreateLphStrukturVisiMisi;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Pages\EditLphStrukturVisiMisi;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Pages\ListLphStrukturVisiMisis;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Schemas\LphStrukturVisiMisiForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Tables\LphStrukturVisiMisisTable;
use App\Models\LphStrukturVisiMisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LphStrukturVisiMisiResource extends Resource
{
    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static ?string $model = LphStrukturVisiMisi::class;

    protected static ?string $navigationLabel = 'Struktur, Visi & Misi';

    protected static ?string $pluralLabel = 'Struktur, Visi & Misi';

    protected static ?string $modelLabel = 'Struktur, Visi & Misi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LphStrukturVisiMisiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LphStrukturVisiMisisTable::configure($table);
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
            'index' => ListLphStrukturVisiMisis::route('/'),
            'create' => CreateLphStrukturVisiMisi::route('/create'),
            'edit' => EditLphStrukturVisiMisi::route('/{record}/edit'),
        ];
    }
}
