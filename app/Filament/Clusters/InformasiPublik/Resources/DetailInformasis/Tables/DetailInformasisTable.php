<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DetailInformasis\Tables;

use App\Models\DetailInformasi;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DetailInformasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tipe')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => DetailInformasi::TIPE_OPTIONS[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'berkala' => 'success',
                        'setiap_saat' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('kategori_id')
                    ->label('Kategori')
                    ->formatStateUsing(function (string $state, DetailInformasi $record): string {
                        $allKategori = array_merge(
                            DetailInformasi::KATEGORI_BERKALA,
                            DetailInformasi::KATEGORI_SETIAP_SAAT,
                        );

                        return $allKategori[$state] ?? $state;
                    })
                    ->searchable(),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('tipe')
                    ->label('Tipe Informasi')
                    ->options(DetailInformasi::TIPE_OPTIONS),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
