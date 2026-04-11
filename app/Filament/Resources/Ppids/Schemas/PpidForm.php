<?php

namespace App\Filament\Resources\Ppids\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class PpidForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('structure_image')
                    ->image()
                    ->disk('public')
                    ->directory('ppid')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->label('Gambar Struktur PPID'),
                FileUpload::make('pdf_file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('ppid')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->label('File PDF PPID'),
            ]);
    }
}
