<?php

namespace App\Filament\Clusters\Upp\Resources\UppVisiMisiResource\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UppVisiMisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visi & Misi')
                    ->description('Kelola Visi, Misi, dan Moto UPP.')
                    ->schema([
                        RichEditor::make('visi')
                            ->label('Visi')
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('misi')
                            ->label('Misi')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('moto')
                            ->label('Moto')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
