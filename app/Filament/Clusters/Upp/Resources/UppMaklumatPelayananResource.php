<?php

namespace App\Filament\Clusters\Upp\Resources;

use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Pages\CreateUppMaklumatPelayanan;
use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Pages\EditUppMaklumatPelayanan;
use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Pages\ListUppMaklumatPelayanans;
use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Schemas\UppMaklumatPelayananForm;
use App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Tables\UppMaklumatPelayanansTable;
use App\Filament\Clusters\Upp\UppCluster;
use App\Models\UppMaklumatPelayanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UppMaklumatPelayananResource extends Resource
{
    protected static ?string $model = UppMaklumatPelayanan::class;

    protected static ?string $cluster = UppCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Maklumat Pelayanan';

    public static function form(Schema $schema): Schema
    {
        return UppMaklumatPelayananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UppMaklumatPelayanansTable::configure($table);
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
            'index' => ListUppMaklumatPelayanans::route('/'),
            'create' => CreateUppMaklumatPelayanan::route('/create'),
            'edit' => EditUppMaklumatPelayanan::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return UppMaklumatPelayanan::count() === 0;
    }
}
