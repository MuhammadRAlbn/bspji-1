<?php

namespace App\Filament\Clusters\Kalibrasi\Resources;

use App\Filament\Clusters\Kalibrasi\KalibrasiCluster;
use App\Models\RuangLingkupKalibrasi;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RuangLingkupKalibrasiResource extends Resource
{
    protected static ?string $model = RuangLingkupKalibrasi::class;

    protected static ?string $cluster = KalibrasiCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Ruang Lingkup';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title')
                ->required(),
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('kalibrasi-scope')
                ->visibility('public'),
            Repeater::make('details')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Alat/Detail')
                        ->required(),
                    TextInput::make('price')
                        ->label('Tarif')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                ])
                ->label('Detail Daftar & Tarif')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => RuangLingkupKalibrasiResource\Pages\ListRuangLingkupKalibrasis::route('/'),
            'create' => RuangLingkupKalibrasiResource\Pages\CreateRuangLingkupKalibrasi::route('/create'),
            'edit' => RuangLingkupKalibrasiResource\Pages\EditRuangLingkupKalibrasi::route('/{record}/edit'),
        ];
    }
}
