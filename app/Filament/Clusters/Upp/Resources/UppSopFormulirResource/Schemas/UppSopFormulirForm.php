<?php

namespace App\Filament\Clusters\Upp\Resources\UppSopFormulirResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UppSopFormulirForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('SOP & Formulir')
                    ->description('Kelola dokumen SOP (Gambar) atau Formulir (PDF).')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Dokumen')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Tipe Dokumen')
                            ->options([
                                'sop' => 'SOP (Gambar)',
                                'formulir' => 'Formulir (PDF)',
                            ])
                            ->required()
                            ->live(),
                        FileUpload::make('path')
                            ->label('File SOP (Gambar)')
                            ->image()
                            ->directory('upp/sop')
                            ->disk('public')
                            ->visibility('public')
                            ->required()
                            ->visible(fn (Get $get): bool => $get('type') === 'sop'),
                        FileUpload::make('path')
                            ->label('File Formulir (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('upp/formulir')
                            ->disk('public')
                            ->visibility('public')
                            ->required()
                            ->visible(fn (Get $get): bool => $get('type') === 'formulir'),
                    ]),
            ]);
    }
}
