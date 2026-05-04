<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource\Pages\CreateZonaIntegritasGrafikIkm;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource\Pages\EditZonaIntegritasGrafikIkm;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasGrafikIkmResource\Pages\ListZonaIntegritasGrafikIkms;
use App\Filament\Clusters\ZonaIntegritas\ZonaIntegritasCluster;
use App\Models\ZonaIntegritasGrafikIkm;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ZonaIntegritasGrafikIkmResource extends Resource
{
    protected static ?string $model = ZonaIntegritasGrafikIkm::class;

    protected static ?string $cluster = ZonaIntegritasCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Grafik IKM';

    protected static ?string $modelLabel = 'Grafik IKM';

    protected static ?string $pluralModelLabel = 'Grafik IKM';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('judul')
                ->label('Judul')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            FileUpload::make('gambar')
                ->label('Gambar Grafik')
                ->image()
                ->imageEditor()
                ->disk('public')
                ->directory('zona-integritas/grafik-ikm')
                ->visibility('public')
                ->required()
                ->maxSize(4096)
                ->columnSpanFull(),
            TextInput::make('urutan')
                ->label('Urutan Tampil')
                ->numeric()
                ->default(0)
                ->minValue(0)
                ->helperText('Angka kecil tampil lebih dulu.'),
            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query
                ->orderBy('urutan')
                ->orderByDesc('created_at'))
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public'),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => ListZonaIntegritasGrafikIkms::route('/'),
            'create' => CreateZonaIntegritasGrafikIkm::route('/create'),
            'edit' => EditZonaIntegritasGrafikIkm::route('/{record}/edit'),
        ];
    }
}
