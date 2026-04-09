<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\InfrastrukturLphResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InfrastrukturLphForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Infrastruktur')
                    ->schema([
                        TextInput::make('nama')
                            ->maxLength(255),
                        FileUpload::make('gambar')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('lph/infrastruktur')
                            ->visibility('public'),
                        TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ]),
            ]);
    }
}
