<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis;

use App\Filament\Clusters\InformasiPublik\InformasiPublikCluster;
use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Pages\CreateDetailInformasi;
use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Pages\EditDetailInformasi;
use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Pages\ListDetailInformasis;
use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Schemas\DetailInformasiForm;
use App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Tables\DetailInformasisTable;
use App\Models\DetailInformasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DetailInformasiResource extends Resource
{
    protected static ?string $model = DetailInformasi::class;

    protected static ?string $cluster = InformasiPublikCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static ?string $modelLabel = 'Detail Informasi';

    protected static ?string $pluralModelLabel = 'Detail Informasi';

    public static function form(Schema $schema): Schema
    {
        return DetailInformasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetailInformasisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDetailInformasis::route('/'),
            'create' => CreateDetailInformasi::route('/create'),
            'edit' => EditDetailInformasi::route('/{record}/edit'),
        ];
    }
}
