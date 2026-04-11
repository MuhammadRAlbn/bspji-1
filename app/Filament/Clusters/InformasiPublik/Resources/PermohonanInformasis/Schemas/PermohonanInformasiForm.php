<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class PermohonanInformasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('form_image')
                    ->image()
                    ->disk('public')
                    ->directory('permohonan-informasi')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->label('Gambar Formulir Permohonan'),
                FileUpload::make('pdf_file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('permohonan-informasi')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->label('File PDF Permohonan'),
            ]);
    }
}
