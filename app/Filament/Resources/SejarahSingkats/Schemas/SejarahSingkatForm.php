<?php

namespace App\Filament\Resources\SejarahSingkats\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SejarahSingkatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahun')
                    ->required()
                    ->maxLength(255),
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Textarea::make('detail')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('gambar')
                    ->image()
                    ->acceptedFileTypes(['image/webp'])
                    ->directory('sejarah-singkat')
                    ->disk('public')
                    ->visibility('public')
                    ->nullable(),
            ]);
    }
}
