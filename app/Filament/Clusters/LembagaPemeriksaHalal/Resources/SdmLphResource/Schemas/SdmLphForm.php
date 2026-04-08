<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\SdmLphResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SdmLphForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Pegawai'),
                Select::make('kategori')
                    ->options([
                        'Auditor Halal' => 'Auditor Halal',
                        'Dewan Pembina Syariah' => 'Dewan Pembina Syariah',
                    ])
                    ->required()
                    ->label('Kategori'),
            ]);
    }
}
