<?php

namespace App\Filament\Resources\SectionSipintus\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectionSipintusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar_mobile')
                    ->label('Gambar Mobile')
                    ->disk('public'),
                ImageColumn::make('gambar_desktop')
                    ->label('Gambar Desktop')
                    ->disk('public'),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
