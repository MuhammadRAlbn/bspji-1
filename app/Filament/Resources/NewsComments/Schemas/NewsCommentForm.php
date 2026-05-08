<?php

namespace App\Filament\Resources\NewsComments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewsCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('news_id')
                    ->label('Berita')
                    ->relationship('news', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('author_name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(100),
                TextInput::make('author_email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Komentar')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }
}
