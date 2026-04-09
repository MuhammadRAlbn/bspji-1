<?php

namespace App\Filament\Clusters\Upp\Resources;

use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Pages\CreateUppSopFormulir;
use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Pages\EditUppSopFormulir;
use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Pages\ListUppSopFormulirs;
use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Schemas\UppSopFormulirForm;
use App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Tables\UppSopFormulirsTable;
use App\Filament\Clusters\Upp\UppCluster;
use App\Models\UppSopFormulir;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UppSopFormulirResource extends Resource
{
    protected static ?string $model = UppSopFormulir::class;

    protected static ?string $cluster = UppCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static ?string $navigationLabel = 'SOP & Formulir';

    public static function form(Schema $schema): Schema
    {
        return UppSopFormulirForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UppSopFormulirsTable::configure($table);
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
            'index' => ListUppSopFormulirs::route('/'),
            'create' => CreateUppSopFormulir::route('/create'),
            'edit' => EditUppSopFormulir::route('/{record}/edit'),
        ];
    }
}
