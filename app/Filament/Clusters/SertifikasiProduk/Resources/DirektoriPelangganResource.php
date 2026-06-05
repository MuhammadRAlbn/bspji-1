<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Pages\CreateDirektoriPelanggan;
use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Pages\EditDirektoriPelanggan;
use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Pages\ListDirektoriPelanggans;
use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Schemas\DirektoriPelangganForm;
use App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Tables\DirektoriPelanggansTable;
use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\DirektoriPelanggan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DirektoriPelangganResource extends Resource
{
    protected static ?string $model = DirektoriPelanggan::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $navigationLabel = 'Direktori Pelanggan';

    protected static ?string $pluralModelLabel = 'Direktori Pelanggan';

    protected static ?string $modelLabel = 'Direktori Pelanggan';

    public static function form(Schema $schema): Schema
    {
        return DirektoriPelangganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DirektoriPelanggansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDirektoriPelanggans::route('/'),
            'create' => CreateDirektoriPelanggan::route('/create'),
            'edit' => EditDirektoriPelanggan::route('/{record}/edit'),
        ];
    }
}
