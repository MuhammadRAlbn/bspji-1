<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LphTarifForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tarif')
                    ->schema([
                        TextInput::make('nama_tarif')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('file_iframe')
                            ->label('PDF (Tampilan Iframe)')
                            ->helperText('PDF ini akan ditampilkan langsung di halaman menggunakan iframe.')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->directory('lph/tarif')
                            ->visibility('public'),
                        FileUpload::make('file_download')
                            ->label('PDF (Download)')
                            ->helperText('PDF ini hanya akan ditampilkan namanya dengan icon download.')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->directory('lph/tarif')
                            ->visibility('public'),
                    ]),
            ]);
    }
}
