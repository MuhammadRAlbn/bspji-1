<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources;

use App\Filament\Clusters\KonsultasiPendampingan\KonsultasiPendampinganCluster;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Pages\CreateKonsultasiAlur;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Pages\EditKonsultasiAlur;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Pages\ListKonsultasiAlurs;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Schemas\KonsultasiAlurForm;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Tables\KonsultasiAlursTable;
use App\Models\KonsultasiAlur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KonsultasiAlurResource extends Resource
{
    protected static ?string $cluster = KonsultasiPendampinganCluster::class;

    protected static ?string $model = KonsultasiAlur::class;

    protected static ?string $navigationLabel = 'Alur';

    protected static ?string $pluralLabel = 'Alur';

    protected static ?string $modelLabel = 'Alur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    public static function form(Schema $schema): Schema
    {
        return KonsultasiAlurForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KonsultasiAlursTable::configure($table);
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
            'index' => ListKonsultasiAlurs::route('/'),
            'create' => CreateKonsultasiAlur::route('/create'),
            'edit' => EditKonsultasiAlur::route('/{record}/edit'),
        ];
    }
}
