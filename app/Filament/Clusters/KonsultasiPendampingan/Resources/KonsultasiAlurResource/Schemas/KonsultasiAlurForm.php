<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiAlurResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KonsultasiAlurForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Alur Konsultansi dan Pendampingan')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Alur')
                            ->image()
                            ->directory('konsultasi/alur')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
