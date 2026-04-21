<?php

namespace App\Filament\Resources\SectionLayanans;

use App\Filament\Resources\SectionLayanans\Pages\CreateSectionLayanan;
use App\Filament\Resources\SectionLayanans\Pages\EditSectionLayanan;
use App\Filament\Resources\SectionLayanans\Pages\ListSectionLayanans;
use App\Filament\Resources\SectionLayanans\Schemas\SectionLayananForm;
use App\Filament\Resources\SectionLayanans\Tables\SectionLayanansTable;
use App\Models\SectionLayanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SectionLayananResource extends Resource
{
    protected static ?string $model = SectionLayanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Landing Page';

    protected static ?string $modelLabel = 'Section Layanan';

    protected static ?string $pluralModelLabel = 'Section Layanan';

    protected static ?string $navigationLabel = 'Section Layanan';

    public static function form(Schema $schema): Schema
    {
        return SectionLayananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectionLayanansTable::configure($table);
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
            'index' => ListSectionLayanans::route('/'),
            'create' => CreateSectionLayanan::route('/create'),
            'edit' => EditSectionLayanan::route('/{record}/edit'),
        ];
    }
}
