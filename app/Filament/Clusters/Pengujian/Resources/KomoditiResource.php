<?php

namespace App\Filament\Clusters\Pengujian\Resources;

use App\Filament\Clusters\Pengujian\PengujianCluster;
use App\Filament\Clusters\Pengujian\Resources\KomoditiResource\Pages;
use App\Filament\Clusters\Pengujian\Resources\KomoditiResource\RelationManagers\ParameterRelationManager;
use App\Models\Komoditi;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KomoditiResource extends Resource
{
    protected static ?string $model = Komoditi::class;

    protected static ?string $cluster = PengujianCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;

    protected static ?string $navigationLabel = 'Tarif Pengujian';

    protected static ?string $modelLabel = 'Komoditi';

    protected static ?string $pluralModelLabel = 'Komoditi';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama')
                ->required()
                ->maxLength(255),
            Select::make('lab_id')
                ->label('Lab')
                ->relationship('lab', 'nama', modifyQueryUsing: fn (Builder $query): Builder => $query->orderBy('nama'))
                ->searchable()
                ->preload()
                ->native(false)
                ->required(),
            Textarea::make('peraturan')
                ->rows(4)
                ->columnSpanFull(),
            Textarea::make('keterangan')
                ->rows(4)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query
                ->with(['lab'])
                ->withCount('parameters')
                ->orderBy('nama'))
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lab.nama')
                    ->label('Lab')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parameters_count')
                    ->label('Jumlah Parameter')
                    ->counts('parameters')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('lab')
                    ->label('Lab')
                    ->relationship('lab', 'nama')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ParameterRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomoditis::route('/'),
            'create' => Pages\CreateKomoditi::route('/create'),
            'edit' => Pages\EditKomoditi::route('/{record}/edit'),
        ];
    }
}
