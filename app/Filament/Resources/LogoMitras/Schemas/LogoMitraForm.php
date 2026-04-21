<?php

namespace App\Filament\Resources\LogoMitras\Schemas;

use App\Models\LogoMitra;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class LogoMitraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tipe')
                    ->label('Jenis Gambar')
                    ->options(function (string $operation): array {
                        $options = [
                            LogoMitra::TYPE_LOGO => 'Logo Mitra',
                        ];

                        $pelengkapExists = LogoMitra::query()
                            ->where('tipe', LogoMitra::TYPE_PELENGKAP)
                            ->exists();

                        if (! $pelengkapExists || $operation === 'edit') {
                            $options[LogoMitra::TYPE_PELENGKAP] = 'Gambar Pelengkap';
                        }

                        return $options;
                    })
                    ->default(LogoMitra::TYPE_LOGO)
                    ->required()
                    ->disabledOn('edit'),
                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/logo-mitra')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
