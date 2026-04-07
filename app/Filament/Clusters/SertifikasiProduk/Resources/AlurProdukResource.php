<?php

namespace App\Filament\Clusters\SertifikasiProduk\Resources;

use App\Filament\Clusters\SertifikasiProduk\SertifikasiProdukCluster;
use App\Models\AlurProduk;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlurProdukResource extends Resource
{
    protected static ?string $model = AlurProduk::class;

    protected static ?string $cluster = SertifikasiProdukCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartLine;

    protected static ?string $navigationLabel = 'Alur Sertifikasi';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('alur-produk')
                ->visibility('public')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => AlurProdukResource\Pages\ListAlurProduks::route('/'),
            'create' => AlurProdukResource\Pages\CreateAlurProduk::route('/create'),
            'edit' => AlurProdukResource\Pages\EditAlurProduk::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return AlurProduk::count() === 0;
    }
}
