<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Pages\CreateInformasiPublikProduk;
use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Pages\EditInformasiPublikProduk;
use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Pages\ListInformasiPublikProduks;
use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Schemas\InformasiPublikProdukForm;
use App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Tables\InformasiPublikProduksTable;
use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\InformasiPublikProduk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InformasiPublikProdukResource extends Resource
{
    protected static ?string $model = InformasiPublikProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentPlus;

    protected static ?string $navigationLabel = 'Informasi Publik';

    public static function form(Schema $schema): Schema
    {
        return InformasiPublikProdukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InformasiPublikProduksTable::configure($table);
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
            'index' => ListInformasiPublikProduks::route('/'),
            'create' => CreateInformasiPublikProduk::route('/create'),
            'edit' => EditInformasiPublikProduk::route('/{record}/edit'),
        ];
    }
}
