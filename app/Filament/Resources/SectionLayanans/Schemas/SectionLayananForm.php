<?php

namespace App\Filament\Resources\SectionLayanans\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SectionLayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/section-layanan')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('detail')
                    ->label('Detail')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
