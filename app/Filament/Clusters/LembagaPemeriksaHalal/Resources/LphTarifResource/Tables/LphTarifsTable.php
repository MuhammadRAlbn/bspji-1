<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphTarifResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LphTarifsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_tarif')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('file_iframe')
                    ->label('Iframe PDF')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => ! empty($record->file_iframe)),
                IconColumn::make('file_download')
                    ->label('Download PDF')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => ! empty($record->file_download)),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
