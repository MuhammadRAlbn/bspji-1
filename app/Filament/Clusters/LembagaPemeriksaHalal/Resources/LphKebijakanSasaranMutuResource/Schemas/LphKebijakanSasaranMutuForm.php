<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LphKebijakanSasaranMutuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('kebijakan')->rows(5),
                Textarea::make('sasaran_mutu')->rows(5),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
