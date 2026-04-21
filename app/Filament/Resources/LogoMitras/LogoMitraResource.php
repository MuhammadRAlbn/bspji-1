<?php

namespace App\Filament\Resources\LogoMitras;

use App\Filament\Resources\LogoMitras\Pages\CreateLogoMitra;
use App\Filament\Resources\LogoMitras\Pages\EditLogoMitra;
use App\Filament\Resources\LogoMitras\Pages\ListLogoMitras;
use App\Filament\Resources\LogoMitras\Schemas\LogoMitraForm;
use App\Filament\Resources\LogoMitras\Tables\LogoMitrasTable;
use App\Models\LogoMitra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LogoMitraResource extends Resource
{
    protected static ?string $model = LogoMitra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static \UnitEnum|string|null $navigationGroup = 'Landing Page';

    protected static ?string $modelLabel = 'Logo Mitra';

    protected static ?string $pluralModelLabel = 'Logo Mitra';

    protected static ?string $navigationLabel = 'Logo Mitra';

    public static function form(Schema $schema): Schema
    {
        return LogoMitraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogoMitrasTable::configure($table);
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
            'index' => ListLogoMitras::route('/'),
            'create' => CreateLogoMitra::route('/create'),
            'edit' => EditLogoMitra::route('/{record}/edit'),
        ];
    }
}
