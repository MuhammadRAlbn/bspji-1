<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Pages\CreateSdmSertifikasiProduk;
use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Pages\EditSdmSertifikasiProduk;
use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Pages\ListSdmSertifikasiProduks;
use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Schemas\SdmSertifikasiProdukForm;
use App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Tables\SdmSertifikasiProduksTable;
use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\SdmSertifikasiProduk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SdmSertifikasiProdukResource extends Resource
{
    protected static ?string $model = SdmSertifikasiProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'SDM';

    protected static ?string $pluralModelLabel = 'SDM';

    protected static ?string $modelLabel = 'SDM';

    public static function form(Schema $schema): Schema
    {
        return SdmSertifikasiProdukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SdmSertifikasiProduksTable::configure($table);
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
            'index' => ListSdmSertifikasiProduks::route('/'),
            'create' => CreateSdmSertifikasiProduk::route('/create'),
            'edit' => EditSdmSertifikasiProduk::route('/{record}/edit'),
        ];
    }
}
