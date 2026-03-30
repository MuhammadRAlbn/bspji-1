<?php

namespace App\Filament\Resources\MottoVisiMisis\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class MottoVisiMisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('visi')
                    ->columnSpanFull(),
                RichEditor::make('misi')
                    ->columnSpanFull(),
            ]);
    }
}
