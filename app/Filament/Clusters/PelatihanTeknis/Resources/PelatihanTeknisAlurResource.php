<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources;

use App\Filament\Clusters\PelatihanTeknis\PelatihanTeknisCluster;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Pages\CreatePelatihanTeknisAlur;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Pages\EditPelatihanTeknisAlur;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Pages\ListPelatihanTeknisAlurs;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Schemas\PelatihanTeknisAlurForm;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Tables\PelatihanTeknisAlursTable;
use App\Models\PelatihanTeknisAlur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PelatihanTeknisAlurResource extends Resource
{
    protected static ?string $cluster = PelatihanTeknisCluster::class;

    protected static ?string $model = PelatihanTeknisAlur::class;

    protected static ?string $navigationLabel = 'Alur';

    protected static ?string $pluralLabel = 'Alur';

    protected static ?string $modelLabel = 'Alur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PelatihanTeknisAlurForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelatihanTeknisAlursTable::configure($table);
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
            'index' => ListPelatihanTeknisAlurs::route('/'),
            'create' => CreatePelatihanTeknisAlur::route('/create'),
            'edit' => EditPelatihanTeknisAlur::route('/{record}/edit'),
        ];
    }
}
