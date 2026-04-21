<?php

namespace App\Filament\Resources\SectionTestimonis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SectionTestimoniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar_pelanggan')
                    ->label('Gambar Pelanggan')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/section-testimoni')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nama_perusahaan')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->maxLength(255),
                Textarea::make('pesan')
                    ->label('Pesan')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
