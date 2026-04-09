<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources\PelatihanTeknisAlurResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PelatihanTeknisAlurForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Alur Pelatihan Teknis')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('pelatihan-teknis/alur')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),
                    ]),
            ]);
    }
}
