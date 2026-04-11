<?php

namespace App\Filament\Clusters\Upp\Resources;

use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Pages\CreateSaranaPrasarana;
use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Pages\EditSaranaPrasarana;
use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Pages\ListSaranaPrasaranas;
use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Schemas\SaranaPrasaranaForm;
use App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Tables\SaranaPrasaranasTable;
use App\Filament\Clusters\Upp\UppCluster;
use App\Models\SaranaPrasarana;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SaranaPrasaranaResource extends Resource
{
    protected static ?string $model = SaranaPrasarana::class;

    protected static ?string $cluster = UppCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Sarana & Prasarana';

    public static function canCreate(): bool
    {
        return SaranaPrasarana::count() === 0;
    }

    public static function form(Schema $schema): Schema
    {
        return SaranaPrasaranaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SaranaPrasaranasTable::configure($table);
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
            'index' => ListSaranaPrasaranas::route('/'),
            'create' => CreateSaranaPrasarana::route('/create'),
            'edit' => EditSaranaPrasarana::route('/{record}/edit'),
        ];
    }
}
