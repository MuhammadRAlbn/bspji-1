<?php

namespace App\Filament\Resources\DokumenProduks;

use App\Filament\Resources\DokumenProduks\Pages\CreateDokumenProduk;
use App\Filament\Resources\DokumenProduks\Pages\EditDokumenProduk;
use App\Filament\Resources\DokumenProduks\Pages\ListDokumenProduks;
use App\Filament\Resources\DokumenProduks\Schemas\DokumenProdukForm;
use App\Filament\Resources\DokumenProduks\Tables\DokumenProduksTable;
use App\Models\DokumenProduk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DokumenProdukResource extends Resource
{
    protected static ?string $model = DokumenProduk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DokumenProdukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DokumenProduksTable::configure($table);
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
            'index' => ListDokumenProduks::route('/'),
            'create' => CreateDokumenProduk::route('/create'),
            'edit' => EditDokumenProduk::route('/{record}/edit'),
        ];
    }
}
