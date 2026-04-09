<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources;

use App\Filament\Clusters\KonsultasiPendampingan\KonsultasiPendampinganCluster;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Pages\CreateKonsultasiRuangLingkup;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Pages\EditKonsultasiRuangLingkup;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Pages\ListKonsultasiRuangLingkups;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Schemas\KonsultasiRuangLingkupForm;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Tables\KonsultasiRuangLingkupsTable;
use App\Models\KonsultasiRuangLingkup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KonsultasiRuangLingkupResource extends Resource
{
    protected static ?string $cluster = KonsultasiPendampinganCluster::class;

    protected static ?string $model = KonsultasiRuangLingkup::class;

    protected static ?string $navigationLabel = 'Ruang Lingkup';

    protected static ?string $pluralLabel = 'Ruang Lingkup';

    protected static ?string $modelLabel = 'Ruang Lingkup';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    public static function form(Schema $schema): Schema
    {
        return KonsultasiRuangLingkupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KonsultasiRuangLingkupsTable::configure($table);
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
            'index' => ListKonsultasiRuangLingkups::route('/'),
            'create' => CreateKonsultasiRuangLingkup::route('/create'),
            'edit' => EditKonsultasiRuangLingkup::route('/{record}/edit'),
        ];
    }
}
