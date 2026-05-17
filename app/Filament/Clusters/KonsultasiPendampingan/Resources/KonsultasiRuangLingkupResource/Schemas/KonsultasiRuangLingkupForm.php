<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KonsultasiRuangLingkupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ruang Lingkup Konsultansi dan Pendampingan')
                    ->schema([
                        Select::make('type')
                            ->label('Tipe Konten')
                            ->options([
                                'paragraph' => 'Paragraf',
                                'image' => 'Gambar',
                            ])
                            ->default('paragraph')
                            ->required()
                            ->live(),

                        RichEditor::make('content')
                            ->label('Deskripsi/Paragraf')
                            ->required(fn ($get) => $get('type') === 'paragraph')
                            ->visible(fn ($get) => $get('type') === 'paragraph')
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Gambar')
                            ->image()
                            ->directory('konsultasi/ruang-lingkup')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->required(fn ($get) => $get('type') === 'image')
                            ->visible(fn ($get) => $get('type') === 'image')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
