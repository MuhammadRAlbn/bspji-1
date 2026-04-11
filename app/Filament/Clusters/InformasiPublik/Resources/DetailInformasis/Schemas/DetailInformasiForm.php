<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Schemas;

use App\Models\DetailInformasi;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DetailInformasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tipe')
                    ->options(DetailInformasi::TIPE_OPTIONS)
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Select $component) => $component
                        ->getContainer()
                        ->getComponent('kategoriField')
                        ->getChildSchema()
                        ->fill())
                    ->label('Tipe Informasi')
                    ->columnSpanFull(),

                Select::make('kategori_id')
                    ->options(fn (Get $get): array => DetailInformasi::getKategoriByTipe($get('tipe')))
                    ->required()
                    ->searchable()
                    ->label('Kategori')
                    ->key('kategoriField')
                    ->columnSpanFull(),

                TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Dokumen')
                    ->columnSpanFull(),

                FileUpload::make('pdf_file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('detail-informasi')
                    ->visibility('public')
                    ->required()
                    ->label('File PDF')
                    ->columnSpanFull(),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('urutan')
                    ->numeric()
                    ->default(0)
                    ->label('Urutan Tampil')
                    ->helperText('Angka kecil tampil lebih dulu'),
            ]);
    }
}
