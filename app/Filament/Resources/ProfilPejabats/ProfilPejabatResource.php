<?php

namespace App\Filament\Resources\ProfilPejabats;

use App\Filament\Resources\ProfilPejabats\Pages\CreateProfilPejabat;
use App\Filament\Resources\ProfilPejabats\Pages\EditProfilPejabat;
use App\Filament\Resources\ProfilPejabats\Pages\ListProfilPejabats;
use App\Filament\Resources\ProfilPejabats\Schemas\ProfilPejabatForm;
use App\Filament\Resources\ProfilPejabats\Tables\ProfilPejabatsTable;
use App\Models\ProfilPejabat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProfilPejabatResource extends Resource
{
    protected static ?string $model = ProfilPejabat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static \UnitEnum|string|null $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Profil Pejabat';

    protected static ?string $pluralModelLabel = 'Profil Pejabat';

    protected static ?string $navigationLabel = 'Profil Pejabat';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return ProfilPejabatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfilPejabatsTable::configure($table);
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
            'index' => ListProfilPejabats::route('/'),
            'create' => CreateProfilPejabat::route('/create'),
            'edit' => EditProfilPejabat::route('/{record}/edit'),
        ];
    }
}
