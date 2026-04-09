<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources;

use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Pages\CreateTkdnRuangLingkup;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Pages\EditTkdnRuangLingkup;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Pages\ListTkdnRuangLingkups;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Schemas\TkdnRuangLingkupForm;
use App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Tables\TkdnRuangLingkupsTable;
use App\Filament\Clusters\VerifikasiTkdn\VerifikasiTkdnCluster;
use App\Models\TkdnRuangLingkup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TkdnRuangLingkupResource extends Resource
{
    protected static ?string $cluster = VerifikasiTkdnCluster::class;

    protected static ?string $model = TkdnRuangLingkup::class;

    protected static ?string $navigationLabel = 'Ruang Lingkup';

    protected static ?string $pluralLabel = 'Ruang Lingkup';

    protected static ?string $modelLabel = 'Ruang Lingkup';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TkdnRuangLingkupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TkdnRuangLingkupsTable::configure($table);
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
            'index' => ListTkdnRuangLingkups::route('/'),
            'create' => CreateTkdnRuangLingkup::route('/create'),
            'edit' => EditTkdnRuangLingkup::route('/{record}/edit'),
        ];
    }
}
