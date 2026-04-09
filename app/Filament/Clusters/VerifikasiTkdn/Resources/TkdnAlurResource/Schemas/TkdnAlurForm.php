<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnAlurResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TkdnAlurForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Alur Verifikasi TKDN')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('tkdn/alur')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),
                    ]),
            ]);
    }
}
