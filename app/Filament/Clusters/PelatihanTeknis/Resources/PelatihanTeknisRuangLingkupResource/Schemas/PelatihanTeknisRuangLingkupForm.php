<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisRuangLingkupResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PelatihanTeknisRuangLingkupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ruang Lingkup Pelatihan Teknis')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('pelatihan-teknis/ruang-lingkup')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),
                    ]),
            ]);
    }
}
