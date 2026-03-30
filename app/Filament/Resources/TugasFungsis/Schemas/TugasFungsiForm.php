<?php

namespace App\Filament\Resources\TugasFungsis\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class TugasFungsiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('tugas')
                    ->columnSpanFull(),
                RichEditor::make('fungsi')
                    ->columnSpanFull(),
            ]);
    }
}
