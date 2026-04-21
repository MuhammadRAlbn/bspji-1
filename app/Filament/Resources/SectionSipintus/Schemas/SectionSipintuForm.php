<?php

namespace App\Filament\Resources\SectionSipintus\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class SectionSipintuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('gambar_mobile')
                    ->label('Gambar Mobile')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/section-sipintu/mobile')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->requiredWithout('gambar_desktop'),
                FileUpload::make('gambar_desktop')
                    ->label('Gambar Desktop')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/section-sipintu/desktop')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->requiredWithout('gambar_mobile'),
            ])
            ->columns(2);
    }
}
