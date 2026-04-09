<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources;

use App\Filament\Clusters\PelatihanTeknis\PelatihanTeknisCluster;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Pages\CreatePelatihanTeknisRuangLingkup;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Pages\EditPelatihanTeknisRuangLingkup;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Pages\ListPelatihanTeknisRuangLingkups;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Schemas\PelatihanTeknisRuangLingkupForm;
use App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Tables\PelatihanTeknisRuangLingkupsTable;
use App\Models\PelatihanTeknisRuangLingkup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PelatihanTeknisRuangLingkupResource extends Resource
{
    protected static ?string $cluster = PelatihanTeknisCluster::class;

    protected static ?string $model = PelatihanTeknisRuangLingkup::class;

    protected static ?string $navigationLabel = 'Ruang Lingkup';

    protected static ?string $pluralLabel = 'Ruang Lingkup';

    protected static ?string $modelLabel = 'Ruang Lingkup';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PelatihanTeknisRuangLingkupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelatihanTeknisRuangLingkupsTable::configure($table);
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
            'index' => ListPelatihanTeknisRuangLingkups::route('/'),
            'create' => CreatePelatihanTeknisRuangLingkup::route('/create'),
            'edit' => EditPelatihanTeknisRuangLingkup::route('/{record}/edit'),
        ];
    }
}
