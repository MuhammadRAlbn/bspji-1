<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class DaftarInformasiPublikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('pdf_file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('daftar-informasi-publik')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->required()
                    ->label('File PDF Daftar Informasi Publik'),
            ]);
    }
}
