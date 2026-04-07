<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\Resources\DokumenProdukResource\Pages;
use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\DokumenProduk;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DokumenProdukResource extends Resource
{
    protected static ?string $model = DokumenProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentPlus;

    protected static ?string $navigationLabel = 'Dokumen';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_dokumen')
                ->label('Nama Dokumen')
                ->required()
                ->maxLength(255),
            FileUpload::make('file_path')
                ->label('Berkas Dokumen')
                ->disk('public')
                ->directory('dokumen-produk')
                ->visibility('public')
                ->preserveFilenames()
                ->acceptedFileTypes([
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                ])
                ->required()
                ->maxSize(5120), // 5MB default
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (DokumenProduk $record) {
                        $path = Storage::disk('public')->path($record->file_path);
                        $extension = pathinfo($path, PATHINFO_EXTENSION);

                        return response()->download(
                            $path,
                            $record->nama_dokumen.'.'.$extension
                        );
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokumenProduks::route('/'),
            'create' => Pages\CreateDokumenProduk::route('/create'),
            'edit' => Pages\EditDokumenProduk::route('/{record}/edit'),
        ];
    }
}
