<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal\Resources\LphKebijakanSasaranMutuResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LphKebijakanSasaranMutusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kebijakan')
                    ->limit(50),
                TextColumn::make('sasaran_mutu')
                    ->limit(50),
                TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
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
