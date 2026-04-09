<?php

namespace App\Filament\Clusters\KonsultasiPendampingan\Resources\KonsultasiRuangLingkupResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KonsultasiRuangLingkupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paragraph' => 'info',
                        'image' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paragraph' => 'Paragraf',
                        'image' => 'Gambar',
                        default => $state,
                    }),
                TextColumn::make('content')
                    ->label('Konten')
                    ->html()
                    ->limit(50)
                    ->placeholder('N/A (Gambar)')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Pratinjau Gambar')
                    ->disk('public'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }
}
