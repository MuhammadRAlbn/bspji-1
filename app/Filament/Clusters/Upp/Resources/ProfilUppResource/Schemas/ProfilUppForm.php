<?php

namespace App\Filament\Clusters\Upp\Resources\ProfilUppResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfilUppForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Motto Pelayanan')
                    ->description('Gambar/Poster Motto Pelayanan UPP.')
                    ->schema([
                        FileUpload::make('moto_pelayanan_path')
                            ->label('Banner Motto Pelayanan')
                            ->image()
                            ->imageEditor()
                            ->directory('upp/profil')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),

                Section::make('Tupoksi')
                    ->description('Tugas Pokok dan Fungsi UPP.')
                    ->schema([
                        RichEditor::make('tupoksi')
                            ->label('Konten Tupoksi')
                            ->columnSpanFull(),
                    ]),

                Section::make('Waktu Pelayanan')
                    ->description('Daftar hari dan jam pelayanan.')
                    ->schema([
                        Repeater::make('waktu_pelayanan')
                            ->label('Jadwal Pelayanan')
                            ->schema([
                                TextInput::make('hari')
                                    ->required()
                                    ->placeholder('Senin sd Kamis')
                                    ->label('Hari'),
                                TextInput::make('waktu')
                                    ->required()
                                    ->placeholder('Pukul 08.00 - 12.00 WIB sd 13.30 - 16.00')
                                    ->label('Waktu'),
                            ])
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['hari'] ?? null)
                            ->addActionLabel('Tambah Jadwal'),
                    ]),
            ]);
    }
}
