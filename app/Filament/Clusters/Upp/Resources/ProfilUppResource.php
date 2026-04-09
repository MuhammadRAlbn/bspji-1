<?php

namespace App\Filament\Clusters\Upp\Resources;

use App\Filament\Clusters\Upp\Resources\ProfilUppResource\Pages\CreateProfilUpp;
use App\Filament\Clusters\Upp\Resources\ProfilUppResource\Pages\EditProfilUpp;
use App\Filament\Clusters\Upp\Resources\ProfilUppResource\Pages\ListProfilUpps;
use App\Filament\Clusters\Upp\Resources\ProfilUppResource\Schemas\ProfilUppForm;
use App\Filament\Clusters\Upp\Resources\ProfilUppResource\Tables\ProfilUppsTable;
use App\Filament\Clusters\Upp\UppCluster;
use App\Models\ProfilUpp;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProfilUppResource extends Resource
{
    protected static ?string $cluster = UppCluster::class;

    protected static ?string $model = ProfilUpp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProfilUppForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfilUppsTable::configure($table);
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
            'index' => ListProfilUpps::route('/'),
            'create' => CreateProfilUpp::route('/create'),
            'edit' => EditProfilUpp::route('/{record}/edit'),
        ];
    }
}
