<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources\TkdnRuangLingkupResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TkdnRuangLingkupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ruang Lingkup Verifikasi TKDN')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('tkdn/ruang-lingkup')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),
                    ]),
            ]);
    }
}
