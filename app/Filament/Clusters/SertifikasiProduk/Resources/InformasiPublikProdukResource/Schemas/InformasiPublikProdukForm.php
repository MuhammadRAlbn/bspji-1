<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\InformasiPublikProdukResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InformasiPublikProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Informasi')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('file_path')
                    ->label('Berkas Dokumen')
                    ->disk('public')
                    ->directory('informasi-publik-produk')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/msword',
                    ])
                    ->required()
                    ->maxSize(5120), // 5MB
            ]);
    }
}
