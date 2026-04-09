<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiTarifResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KonsultasiTarifForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tarif Konsultasi dan Pendampingan')
                    ->schema([
                        FileUpload::make('file_pdf')
                            ->label('Dokumen PDF Tarif')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('konsultasi/tarif')
                            ->disk('public')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
