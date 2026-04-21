<?php

namespace App\Filament\Resources\SertifikatPerusahaans\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SertifikatPerusahaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar')
                    ->label('Gambar Sertifikat')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/sertifikat')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('nama_sertifikat')
                    ->label('Nama Sertifikat')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
