<?php

namespace App\Filament\Clusters\Upp\Resources\UppMaklumatPelayananResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UppMaklumatPelayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Maklumat Pelayanan')
                    ->description('Upload gambar maklumat pelayanan UPP.')
                    ->schema([
                        FileUpload::make('path')
                            ->image()
                            ->directory('upp/maklumat')
                            ->disk('public')
                            ->visibility('public')
                            ->label('Gambar Maklumat Pelayanan')
                            ->required(),
                    ]),
            ]);
    }
}
