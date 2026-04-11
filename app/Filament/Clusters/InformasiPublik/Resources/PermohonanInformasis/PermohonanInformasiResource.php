<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis;

use App\Filament\Clusters\InformasiPublik\InformasiPublikCluster;
use App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Pages\EditPermohonanInformasi;
use App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Pages\ListPermohonanInformasis;
use App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Schemas\PermohonanInformasiForm;
use App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Tables\PermohonanInformasisTable;
use App\Models\PermohonanInformasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PermohonanInformasiResource extends Resource
{
    protected static ?string $model = PermohonanInformasi::class;

    protected static ?string $cluster = InformasiPublikCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $modelLabel = 'Permohonan Informasi';

    protected static ?string $pluralModelLabel = 'Permohonan Informasi';

    public static function form(Schema $schema): Schema
    {
        return PermohonanInformasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermohonanInformasisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermohonanInformasis::route('/'),
            'edit' => EditPermohonanInformasi::route('/{record}/edit'),
        ];
    }
}
