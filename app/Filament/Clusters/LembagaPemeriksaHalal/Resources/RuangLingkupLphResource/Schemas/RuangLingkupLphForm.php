<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\RuangLingkupLphResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RuangLingkupLphForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('lph/ruang-lingkup')
                    ->label('Gambar (Opsional)'),
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Ruang Lingkup'),
            ]);
    }
}
