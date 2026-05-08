<?php

namespace App\Filament\Resources\NewsComments;

use App\Filament\Resources\NewsComments\Pages\EditNewsComment;
use App\Filament\Resources\NewsComments\Pages\ListNewsComments;
use App\Filament\Resources\NewsComments\Schemas\NewsCommentForm;
use App\Filament\Resources\NewsComments\Tables\NewsCommentsTable;
use App\Models\NewsComment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NewsCommentResource extends Resource
{
    protected static ?string $model = NewsComment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static \UnitEnum|string|null $navigationGroup = 'Berita';

    protected static ?string $modelLabel = 'Komentar Berita';

    protected static ?string $pluralModelLabel = 'Komentar Berita';

    protected static ?string $navigationLabel = 'Komentar';

    public static function form(Schema $schema): Schema
    {
        return NewsCommentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsCommentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsComments::route('/'),
            'edit' => EditNewsComment::route('/{record}/edit'),
        ];
    }
}
