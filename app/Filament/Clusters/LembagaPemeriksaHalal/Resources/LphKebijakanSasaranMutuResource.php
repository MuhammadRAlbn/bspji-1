<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Pages\CreateLphKebijakanSasaranMutu;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Pages\EditLphKebijakanSasaranMutu;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Pages\ListLphKebijakanSasaranMutus;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Schemas\LphKebijakanSasaranMutuForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Tables\LphKebijakanSasaranMutusTable;
use App\Models\LphKebijakanSasaranMutu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LphKebijakanSasaranMutuResource extends Resource
{
    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static ?string $model = LphKebijakanSasaranMutu::class;

    protected static ?string $navigationLabel = 'Kebijakan & Sasaran Mutu';

    protected static ?string $pluralLabel = 'Kebijakan & Sasaran Mutu';

    protected static ?string $modelLabel = 'Kebijakan & Sasaran Mutu';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LphKebijakanSasaranMutuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LphKebijakanSasaranMutusTable::configure($table);
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
            'index' => ListLphKebijakanSasaranMutus::route('/'),
            'create' => CreateLphKebijakanSasaranMutu::route('/create'),
            'edit' => EditLphKebijakanSasaranMutu::route('/{record}/edit'),
        ];
    }
}
