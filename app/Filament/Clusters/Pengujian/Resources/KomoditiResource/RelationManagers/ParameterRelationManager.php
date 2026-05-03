<?php

namespace App\Filament\Clusters\Pengujian\Resources\KomoditiResource\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;

class ParameterRelationManager extends RelationManager
{
    protected static string $relationship = 'parameters';

    protected static ?string $title = 'Parameter';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama')
                ->required()
                ->maxLength(255),
            Select::make('lab_id')
                ->label('Lab')
                ->relationship('lab', 'nama', modifyQueryUsing: fn (Builder $query): Builder => $query->orderBy('nama'))
                ->default(fn (): ?int => $this->getOwnerRecord()->lab_id)
                ->searchable()
                ->preload()
                ->native(false)
                ->required(),
            TextInput::make('metode_uji')
                ->maxLength(255),
            TextInput::make('satuan')
                ->maxLength(255),
            Textarea::make('baku_mutu')
                ->rows(3)
                ->columnSpanFull(),
            TextInput::make('harga')
                ->numeric()
                ->prefix('Rp')
                ->minValue(0)
                ->dehydrateStateUsing(fn (mixed $state): ?int => blank($state) ? null : (int) $state),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query
                ->with(['lab'])
                ->orderBy('nama'))
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('metode_uji')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('satuan')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('baku_mutu')
                    ->limit(40)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('harga')
                    ->alignEnd()
                    ->formatStateUsing(fn (int|string|null $state): string => blank($state) ? '-' : Number::currency((int) $state, 'IDR', 'id')),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
