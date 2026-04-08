<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Pages\CreateLphAlurDanKelengkapan;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Pages\EditLphAlurDanKelengkapan;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Pages\ListLphAlurDanKelengkapans;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Schemas\LphAlurDanKelengkapanForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Tables\LphAlurDanKelengkapansTable;
use App\Models\LphAlurDanKelengkapan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LphAlurDanKelengkapanResource extends Resource
{
    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static ?string $model = LphAlurDanKelengkapan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LphAlurDanKelengkapanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LphAlurDanKelengkapansTable::configure($table);
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
            'index' => ListLphAlurDanKelengkapans::route('/'),
            'create' => CreateLphAlurDanKelengkapan::route('/create'),
            'edit' => EditLphAlurDanKelengkapan::route('/{record}/edit'),
        ];
    }
}
