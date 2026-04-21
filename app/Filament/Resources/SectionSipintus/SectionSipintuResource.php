<?php

namespace App\Filament\Resources\SectionSipintus;

use App\Filament\Resources\SectionSipintus\Pages\CreateSectionSipintu;
use App\Filament\Resources\SectionSipintus\Pages\EditSectionSipintu;
use App\Filament\Resources\SectionSipintus\Pages\ListSectionSipintus;
use App\Filament\Resources\SectionSipintus\Schemas\SectionSipintuForm;
use App\Filament\Resources\SectionSipintus\Tables\SectionSipintusTable;
use App\Models\SectionSipintu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SectionSipintuResource extends Resource
{
    protected static ?string $model = SectionSipintu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDevicePhoneMobile;

    protected static \UnitEnum|string|null $navigationGroup = 'Landing Page';

    protected static ?string $modelLabel = 'Section Sipintu';

    protected static ?string $pluralModelLabel = 'Section Sipintu';

    protected static ?string $navigationLabel = 'Section Sipintu';

    public static function canCreate(): bool
    {
        return ! SectionSipintu::query()->exists();
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
        return SectionSipintuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectionSipintusTable::configure($table);
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
            'index' => ListSectionSipintus::route('/'),
            'create' => CreateSectionSipintu::route('/create'),
            'edit' => EditSectionSipintu::route('/{record}/edit'),
        ];
    }
}
