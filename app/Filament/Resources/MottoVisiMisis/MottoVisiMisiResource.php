<?php

namespace App\Filament\Resources\MottoVisiMisis;

use App\Filament\Resources\MottoVisiMisis\Pages\EditMottoVisiMisi;
use App\Filament\Resources\MottoVisiMisis\Schemas\MottoVisiMisiForm;
use App\Models\MottoVisiMisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class MottoVisiMisiResource extends Resource
{
    protected static ?string $model = MottoVisiMisi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Visi dan Misi';

    protected static ?string $pluralModelLabel = 'Visi dan Misi';

    protected static ?string $navigationLabel = 'Visi dan Misi';

    public static function form(Schema $schema): Schema
    {
        return MottoVisiMisiForm::configure($schema);
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
            'index' => EditMottoVisiMisi::route('/'),
        ];
    }
}
