<?php

namespace App\Filament\Resources\ProfilPejabats\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProfilPejabatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('foto')
                    ->image()
                    ->directory('profil-pejabat')
                    ->columnSpanFull(),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('detail')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
