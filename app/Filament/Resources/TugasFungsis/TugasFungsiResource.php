<?php

namespace App\Filament\Resources\TugasFungsis;

use App\Filament\Resources\TugasFungsis\Pages\EditTugasFungsi;
use App\Filament\Resources\TugasFungsis\Schemas\TugasFungsiForm;
use App\Models\TugasFungsi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TugasFungsiResource extends Resource
{
    protected static ?string $model = TugasFungsi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static \UnitEnum|string|null $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Tugas dan Fungsi';

    protected static ?string $pluralModelLabel = 'Tugas dan Fungsi';

    protected static ?string $navigationLabel = 'Tugas dan Fungsi';

    public static function form(Schema $schema): Schema
    {
        return TugasFungsiForm::configure($schema);
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
            'index' => EditTugasFungsi::route('/'),
        ];
    }
}
