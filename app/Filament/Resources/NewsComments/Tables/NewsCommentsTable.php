<?php

namespace App\Filament\Resources\NewsComments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NewsCommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['news', 'parent'])->latest())
            ->columns([
                TextColumn::make('news.title')
                    ->label('Berita')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('author_name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('content')
                    ->label('Komentar')
                    ->limit(70)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
            ]);
    }
}
