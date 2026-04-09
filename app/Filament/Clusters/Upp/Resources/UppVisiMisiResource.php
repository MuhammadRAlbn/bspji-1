<?php

namespace App\Filament\Clusters\Upp\Resources;

use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Pages\CreateUppVisiMisi;
use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Pages\EditUppVisiMisi;
use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Pages\ListUppVisiMisis;
use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Schemas\UppVisiMisiForm;
use App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Tables\UppVisiMisisTable;
use App\Filament\Clusters\Upp\UppCluster;
use App\Models\UppVisiMisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UppVisiMisiResource extends Resource
{
    protected static ?string $model = UppVisiMisi::class;

    protected static ?string $cluster = UppCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $navigationLabel = 'Visi dan Misi';

    public static function form(Schema $schema): Schema
    {
        return UppVisiMisiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UppVisiMisisTable::configure($table);
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
            'index' => ListUppVisiMisis::route('/'),
            'create' => CreateUppVisiMisi::route('/create'),
            'edit' => EditUppVisiMisi::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return UppVisiMisi::count() === 0;
    }
}
