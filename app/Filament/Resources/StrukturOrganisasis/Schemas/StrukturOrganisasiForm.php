<?php

namespace App\Filament\Resources\StrukturOrganisasis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class StrukturOrganisasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->image()
                    ->disk('public')
                    ->directory('struktur-organisasi')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->required()
                    ->label('Gambar Struktur Organisasi'),
            ]);
    }
}
