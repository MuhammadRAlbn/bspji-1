<?php

namespace App\Filament\Clusters\Upp\Resources\SaranaPrasaranaResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaranaPrasaranaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sarana & Prasarana')
                    ->description('Upload file PDF Sarana dan Prasarana.')
                    ->schema([
                        FileUpload::make('pdf')
                            ->label('File PDF')
                            ->required()
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->visibility('public')
                            ->moveFiles(),
                    ]),
            ]);
    }
}
