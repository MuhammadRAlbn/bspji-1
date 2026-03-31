<?php

namespace App\Filament\Resources\StrukturOrganisasis;

use App\Filament\Resources\StrukturOrganisasis\Pages\EditStrukturOrganisasi;
use App\Filament\Resources\StrukturOrganisasis\Schemas\StrukturOrganisasiForm;
use App\Models\StrukturOrganisasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StrukturOrganisasiResource extends Resource
{
    protected static ?string $model = StrukturOrganisasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Struktur Organisasi';

    protected static ?string $pluralModelLabel = 'Struktur Organisasi';

    protected static ?string $navigationLabel = 'Struktur Organisasi';

    public static function form(Schema $schema): Schema
    {
        return StrukturOrganisasiForm::configure($schema);
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
            'index' => EditStrukturOrganisasi::route('/'),
        ];
    }
}
