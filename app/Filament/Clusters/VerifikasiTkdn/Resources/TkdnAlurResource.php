<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources;

use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Pages\CreateTkdnAlur;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Pages\EditTkdnAlur;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Pages\ListTkdnAlurs;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Schemas\TkdnAlurForm;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Tables\TkdnAlursTable;
use App\Filament\Clusters\VerifikasiTkdn\VerifikasiTkdnCluster;
use App\Models\TkdnAlur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TkdnAlurResource extends Resource
{
    protected static ?string $cluster = VerifikasiTkdnCluster::class;

    protected static ?string $model = TkdnAlur::class;

    protected static ?string $navigationLabel = 'Alur';

    protected static ?string $pluralLabel = 'Alur';

    protected static ?string $modelLabel = 'Alur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TkdnAlurForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TkdnAlursTable::configure($table);
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
            'index' => ListTkdnAlurs::route('/'),
            'create' => CreateTkdnAlur::route('/create'),
            'edit' => EditTkdnAlur::route('/{record}/edit'),
        ];
    }
}
