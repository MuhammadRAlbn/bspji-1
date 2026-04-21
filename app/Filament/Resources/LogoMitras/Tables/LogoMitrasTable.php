<?php

namespace App\Filament\Resources\LogoMitras\Tables;

use App\Models\LogoMitra;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogoMitrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public'),
                TextColumn::make('tipe')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === LogoMitra::TYPE_PELENGKAP ? 'Gambar Pelengkap' : 'Logo Mitra'),
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
                DeleteAction::make()
                    ->visible(fn (LogoMitra $record): bool => $record->tipe === LogoMitra::TYPE_LOGO),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
