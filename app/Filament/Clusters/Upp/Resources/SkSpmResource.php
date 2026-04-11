<?php

namespace App\Filament\Clusters\Upp\Resources;

use App\Filament\Clusters\Upp\Resources\SkSpmResource\Pages\CreateSkSpm;
use App\Filament\Clusters\Upp\Resources\SkSpmResource\Pages\EditSkSpm;
use App\Filament\Clusters\Upp\Resources\SkSpmResource\Pages\ListSkSpms;
use App\Filament\Clusters\Upp\Resources\SkSpmResource\Schemas\SkSpmForm;
use App\Filament\Clusters\Upp\Resources\SkSpmResource\Tables\SkSpmsTable;
use App\Filament\Clusters\Upp\UppCluster;
use App\Models\SkSpm;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SkSpmResource extends Resource
{
    protected static ?string $model = SkSpm::class;

    protected static ?string $cluster = UppCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'SK SPM';

    public static function canCreate(): bool
    {
        return SkSpm::count() === 0;
    }

    public static function form(Schema $schema): Schema
    {
        return SkSpmForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SkSpmsTable::configure($table);
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
            'index' => ListSkSpms::route('/'),
            'create' => CreateSkSpm::route('/create'),
            'edit' => EditSkSpm::route('/{record}/edit'),
        ];
    }
}
