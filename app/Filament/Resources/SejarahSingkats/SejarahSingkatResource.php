<?php

namespace App\Filament\Resources\SejarahSingkats;

use App\Filament\Resources\SejarahSingkats\Pages\CreateSejarahSingkat;
use App\Filament\Resources\SejarahSingkats\Pages\EditSejarahSingkat;
use App\Filament\Resources\SejarahSingkats\Pages\ListSejarahSingkats;
use App\Filament\Resources\SejarahSingkats\Schemas\SejarahSingkatForm;
use App\Filament\Resources\SejarahSingkats\Tables\SejarahSingkatsTable;
use App\Models\SejarahSingkat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SejarahSingkatResource extends Resource
{
    protected static ?string $model = SejarahSingkat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Sejarah Singkat';

    protected static ?string $pluralModelLabel = 'Sejarah Singkat';

    protected static ?string $navigationLabel = 'Sejarah Singkat';

    public static function form(Schema $schema): Schema
    {
        return SejarahSingkatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SejarahSingkatsTable::configure($table);
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
            'index' => ListSejarahSingkats::route('/'),
            'create' => CreateSejarahSingkat::route('/create'),
            'edit' => EditSejarahSingkat::route('/{record}/edit'),
        ];
    }
}
