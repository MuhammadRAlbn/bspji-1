<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphAlurDanKelengkapanResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LphAlurDanKelengkapanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar')
                    ->image()
                    ->disk('public')
                    ->directory('lph/alur-kelengkapan')
                    ->visibility('public'),
                TextInput::make('nama'),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
