<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\Resources\HakKewajibanProdukResource\Pages;
use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\HakKewajibanProduk;
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

class HakKewajibanProdukResource extends Resource
{
    protected static ?string $model = HakKewajibanProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'Hak dan Kewajiban';

    protected static ?string $pluralModelLabel = 'Hak dan Kewajiban';

    protected static ?string $modelLabel = 'Hak dan Kewajiban';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_dokumen')
                ->label('Nama Dokumen')
                ->required()
                ->maxLength(255),
            FileUpload::make('file_path')
                ->label('File Dokumen')
                ->disk('public')
                ->directory('hak-kewajiban-produk')
                ->visibility('public')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
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
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (HakKewajibanProduk $record) {
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
            'index' => Pages\ListHakKewajibanProduks::route('/'),
            'create' => Pages\CreateHakKewajibanProduk::route('/create'),
            'edit' => Pages\EditHakKewajibanProduk::route('/{record}/edit'),
        ];
    }
}
