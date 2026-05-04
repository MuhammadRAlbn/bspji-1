<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource\Pages\CreateZonaIntegritasDokumen;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource\Pages\EditZonaIntegritasDokumen;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasDokumenResource\Pages\ListZonaIntegritasDokumens;
use App\Filament\Clusters\ZonaIntegritas\ZonaIntegritasCluster;
use App\Models\ZonaIntegritasDokumen;
use App\Models\ZonaIntegritasJenisDokumen;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ZonaIntegritasDokumenResource extends Resource
{
    protected static ?string $model = ZonaIntegritasDokumen::class;

    protected static ?string $cluster = ZonaIntegritasCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Dokumen';

    protected static ?string $modelLabel = 'Dokumen Zona Integritas';

    protected static ?string $pluralModelLabel = 'Dokumen Zona Integritas';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('jenis_dokumen_id')
                ->label('Jenis Dokumen')
                ->relationship(
                    'jenisDokumen',
                    'nama',
                    modifyQueryUsing: fn (Builder $query): Builder => $query->orderBy('urutan')->orderBy('nama'),
                )
                ->searchable()
                ->preload()
                ->native(false)
                ->required()
                ->columnSpanFull(),
            TextInput::make('nama_dokumen')
                ->label('Nama Dokumen')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            FileUpload::make('file_path')
                ->label('File PDF')
                ->acceptedFileTypes(['application/pdf'])
                ->disk('public')
                ->directory('zona-integritas/dokumen')
                ->visibility('public')
                ->required()
                ->maxSize(5120)
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
                ->with(['jenisDokumen'])
                ->orderBy('urutan')
                ->orderByDesc('created_at'))
            ->columns([
                TextColumn::make('jenisDokumen.nama')
                    ->label('Jenis')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama_dokumen')
                    ->label('Nama Dokumen')
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
            ->filters([
                SelectFilter::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->options(fn (): array => ZonaIntegritasJenisDokumen::query()
                        ->orderBy('urutan')
                        ->pluck('nama', 'id')
                        ->all()),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (ZonaIntegritasDokumen $record): string => route('zona-integritas.dokumen.download', $record))
                    ->openUrlInNewTab(),
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
            'index' => ListZonaIntegritasDokumens::route('/'),
            'create' => CreateZonaIntegritasDokumen::route('/create'),
            'edit' => EditZonaIntegritasDokumen::route('/{record}/edit'),
        ];
    }
}
