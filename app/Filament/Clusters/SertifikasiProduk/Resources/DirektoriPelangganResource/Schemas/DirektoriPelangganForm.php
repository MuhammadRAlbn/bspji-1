<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\DirektoriPelangganResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DirektoriPelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_perusahaan')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->maxLength(255),
                Textarea::make('alamat')
                    ->label('Alamat')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('merek')
                    ->label('Merek')
                    ->maxLength(255),
                TextInput::make('tahun_sertifikasi')
                    ->label('Tahun Sertifikasi')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(2100),
                TextInput::make('no_sertifikat')
                    ->label('No Sertifikat')
                    ->maxLength(255),
                TextInput::make('no_hp')
                    ->label('No HP')
                    ->maxLength(255),
                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255),
                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->directory('direktori-pelanggan')
                    ->visibility('public')
                    ->maxSize(2048),
            ]);
    }
}
