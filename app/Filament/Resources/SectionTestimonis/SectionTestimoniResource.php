<?php

namespace App\Filament\Resources\SectionTestimonis;

use App\Filament\Resources\SectionTestimonis\Pages\CreateSectionTestimoni;
use App\Filament\Resources\SectionTestimonis\Pages\EditSectionTestimoni;
use App\Filament\Resources\SectionTestimonis\Pages\ListSectionTestimonis;
use App\Filament\Resources\SectionTestimonis\Schemas\SectionTestimoniForm;
use App\Filament\Resources\SectionTestimonis\Tables\SectionTestimonisTable;
use App\Models\SectionTestimoni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SectionTestimoniResource extends Resource
{
    protected static ?string $model = SectionTestimoni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static \UnitEnum|string|null $navigationGroup = 'Landing Page';

    protected static ?string $modelLabel = 'Section Testimoni';

    protected static ?string $pluralModelLabel = 'Section Testimoni';

    protected static ?string $navigationLabel = 'Section Testimoni';

    public static function form(Schema $schema): Schema
    {
        return SectionTestimoniForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectionTestimonisTable::configure($table);
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
            'index' => ListSectionTestimonis::route('/'),
            'create' => CreateSectionTestimoni::route('/create'),
            'edit' => EditSectionTestimoni::route('/{record}/edit'),
        ];
    }
}
