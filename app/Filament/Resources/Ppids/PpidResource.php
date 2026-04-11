<?php

namespace App\Filament\Resources\Ppids;

use App\Filament\Resources\Ppids\Pages\EditPpid;
use App\Filament\Resources\Ppids\Schemas\PpidForm;
use App\Models\Ppid;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PpidResource extends Resource
{
    protected static ?string $model = Ppid::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static \UnitEnum|string|null $navigationGroup = 'Informasi';

    protected static ?string $modelLabel = 'PPID';

    protected static ?string $pluralModelLabel = 'PPID';

    protected static ?string $navigationLabel = 'PPID';

    public static function form(Schema $schema): Schema
    {
        return PpidForm::configure($schema);
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
            'index' => EditPpid::route('/'),
        ];
    }
}
