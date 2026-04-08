<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources\SdmSertifikasiProdukResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SdmSertifikasiProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'ahli_madya' => 'Ahli Madya',
                        'ahli_muda' => 'Ahli Muda',
                        'ahli_pertama' => 'Ahli Pertama',
                    ])
                    ->required(),
            ]);
    }
}
