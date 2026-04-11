<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks;

use App\Filament\Clusters\InformasiPublik\InformasiPublikCluster;
use App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Pages\EditDaftarInformasiPublik;
use App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Pages\ListDaftarInformasiPubliks;
use App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Schemas\DaftarInformasiPublikForm;
use App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Tables\DaftarInformasiPubliksTable;
use App\Models\DaftarInformasiPublik;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DaftarInformasiPublikResource extends Resource
{
    protected static ?string $model = DaftarInformasiPublik::class;

    protected static ?string $cluster = InformasiPublikCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $modelLabel = 'Daftar Informasi Publik';

    protected static ?string $pluralModelLabel = 'Daftar Informasi Publik';

    public static function form(Schema $schema): Schema
    {
        return DaftarInformasiPublikForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DaftarInformasiPubliksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDaftarInformasiPubliks::route('/'),
            'edit' => EditDaftarInformasiPublik::route('/{record}/edit'),
        ];
    }
}
