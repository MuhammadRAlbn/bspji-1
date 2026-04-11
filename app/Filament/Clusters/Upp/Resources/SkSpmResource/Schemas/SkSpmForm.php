<?php

namespace App\Filament\Clusters\Upp\Resources\SkSpmResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SkSpmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('SK SPM')
                    ->description('Upload file PDF SK SPM (Standar Pelayanan Minimal).')
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
