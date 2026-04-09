<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources;

use App\Filament\Clusters\LembagaPemeriksaHalal\LembagaPemeriksaHalalCluster;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Pages\CreateInfrastrukturLph;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Pages\EditInfrastrukturLph;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Pages\ListInfrastrukturLphs;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Schemas\InfrastrukturLphForm;
use App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Tables\InfrastrukturLphsTable;
use App\Models\LphInfrastruktur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InfrastrukturLphResource extends Resource
{
    protected static ?string $cluster = LembagaPemeriksaHalalCluster::class;

    protected static ?string $model = LphInfrastruktur::class;

    protected static ?string $navigationLabel = 'Infrastruktur';

    protected static ?string $pluralLabel = 'Infrastruktur';

    protected static ?string $modelLabel = 'Infrastruktur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    public static function form(Schema $schema): Schema
    {
        return InfrastrukturLphForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InfrastrukturLphsTable::configure($table);
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
            'index' => ListInfrastrukturLphs::route('/'),
            'create' => CreateInfrastrukturLph::route('/create'),
            'edit' => EditInfrastrukturLph::route('/{record}/edit'),
        ];
    }
}
