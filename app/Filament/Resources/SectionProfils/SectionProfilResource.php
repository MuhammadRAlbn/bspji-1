<?php

namespace App\Filament\Resources\SectionProfils;

use App\Filament\Resources\SectionProfils\Pages\CreateSectionProfil;
use App\Filament\Resources\SectionProfils\Pages\EditSectionProfil;
use App\Filament\Resources\SectionProfils\Pages\ListSectionProfils;
use App\Filament\Resources\SectionProfils\Schemas\SectionProfilForm;
use App\Filament\Resources\SectionProfils\Tables\SectionProfilsTable;
use App\Models\SectionProfil;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SectionProfilResource extends Resource
{
    protected static ?string $model = SectionProfil::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Landing Page';

    protected static ?string $modelLabel = 'Section Profil';

    protected static ?string $pluralModelLabel = 'Section Profil';

    protected static ?string $navigationLabel = 'Section Profil';

    public static function canCreate(): bool
    {
        return SectionProfil::query()->count() < 3;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return SectionProfilForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectionProfilsTable::configure($table);
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
            'index' => ListSectionProfils::route('/'),
            'create' => CreateSectionProfil::route('/create'),
            'edit' => EditSectionProfil::route('/{record}/edit'),
        ];
    }
}
