<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\Resources\TarifProdukResource\Pages;
use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\TarifProduk;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TarifProdukResource extends Resource
{
    protected static ?string $model = TarifProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?string $navigationLabel = 'Tarif';

    protected static ?string $pluralModelLabel = 'Tarif';

    protected static ?string $modelLabel = 'Tarif';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_dokumen')
                ->label('Nama Dokumen')
                ->required()
                ->maxLength(255),
            FileUpload::make('file_path')
                ->label('Berkas PDF Tarif')
                ->disk('public')
                ->directory('tarif-produk')
                ->visibility('public')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf'])
                ->required()
                ->maxSize(10240), // 10MB
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_dokumen')
                    ->label('Nama Dokumen')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTarifProduks::route('/'),
            'create' => Pages\CreateTarifProduk::route('/create'),
            'edit' => Pages\EditTarifProduk::route('/{record}/edit'),
        ];
    }
}
