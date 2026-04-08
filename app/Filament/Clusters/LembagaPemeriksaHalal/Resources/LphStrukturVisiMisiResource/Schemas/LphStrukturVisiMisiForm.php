<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphStrukturVisiMisiResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LphStrukturVisiMisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar')
                    ->image()
                    ->disk('public')
                    ->directory('lph/struktur-visi-misi')
                    ->visibility('public'),
                TextInput::make('nama'),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
