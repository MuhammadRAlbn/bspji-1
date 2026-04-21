<?php

namespace App\Filament\Resources\SectionProfils\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class SectionProfilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('foto')
                    ->label('Foto')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('landing-page/section-profil')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
