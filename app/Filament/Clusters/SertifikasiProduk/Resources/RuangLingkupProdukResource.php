<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\RuangLingkupProduk;
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

class RuangLingkupProdukResource extends Resource
{
    protected static ?string $model = RuangLingkupProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

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
                ->directory('produk-scope')
                ->visibility('public'),
            Repeater::make('details')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Produk/Detail')
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
            'index' => RuangLingkupProdukResource\Pages\ListRuangLingkupProduks::route('/'),
            'create' => RuangLingkupProdukResource\Pages\CreateRuangLingkupProduk::route('/create'),
            'edit' => RuangLingkupProdukResource\Pages\EditRuangLingkupProduk::route('/{record}/edit'),
        ];
    }
}
