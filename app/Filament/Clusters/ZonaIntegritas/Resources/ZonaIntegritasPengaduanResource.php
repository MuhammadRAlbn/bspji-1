<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\EditZonaIntegritasPengaduan;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ListZonaIntegritasPengaduans;
use App\Filament\Clusters\ZonaIntegritas\ZonaIntegritasCluster;
use App\Models\ZonaIntegritasPengaduan;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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

class ZonaIntegritasPengaduanResource extends Resource
{
    protected static ?string $model = ZonaIntegritasPengaduan::class;

    protected static ?string $cluster = ZonaIntegritasCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Pengaduan';

    protected static ?string $modelLabel = 'Pengaduan';

    protected static ?string $pluralModelLabel = 'Pengaduan';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nomor_pengaduan')
                ->label('Nomor Pengaduan')
                ->disabled()
                ->dehydrated(false),
            Select::make('status')
                ->label('Status')
                ->options(ZonaIntegritasPengaduan::STATUS_OPTIONS)
                ->native(false)
                ->required(),
            TextInput::make('nama')
                ->label('Nama Pelapor')
                ->disabled()
                ->dehydrated(false),
            TextInput::make('jenis_pengaduan')
                ->label('Jenis Pengaduan')
                ->formatStateUsing(fn (ZonaIntegritasPengaduan $record): string => $record->jenis_pengaduan_label)
                ->disabled()
                ->dehydrated(false),
            TextInput::make('jenis_pelanggaran_label')
                ->label('Jenis Pelanggaran')
                ->formatStateUsing(fn (ZonaIntegritasPengaduan $record): string => $record->jenis_pelanggaran_label)
                ->disabled()
                ->dehydrated(false)
                ->columnSpanFull(),
            TextInput::make('nama_dilaporkan')
                ->label('Nama Yang Dilaporkan')
                ->disabled()
                ->dehydrated(false),
            TextInput::make('judul')
                ->label('Judul')
                ->disabled()
                ->dehydrated(false),
            Textarea::make('uraian')
                ->label('Uraian Pengaduan')
                ->rows(6)
                ->disabled()
                ->dehydrated(false)
                ->columnSpanFull(),
            Textarea::make('hasil_teks')
                ->label('Hasil Pengaduan')
                ->rows(5)
                ->helperText('Wajib diisi jika status Pengaduan selesai dan tidak ada dokumen hasil.')
                ->columnSpanFull(),
            FileUpload::make('dokumen_hasil_path')
                ->label('Dokumen Hasil')
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                ->disk('local')
                ->directory('zona-integritas/pengaduan/hasil')
                ->maxSize(5120)
                ->helperText('Maksimal 5 MB. Wajib jika status Pengaduan selesai dan hasil teks kosong.')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->latestFirst())
            ->columns([
                TextColumn::make('nomor_pengaduan')
                    ->label('Nomor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('jenis_pengaduan_label')
                    ->label('Jenis')
                    ->badge(),
                TextColumn::make('status_label')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ZonaIntegritasPengaduan $record): string => match ($record->status) {
                        ZonaIntegritasPengaduan::STATUS_DITERIMA => 'info',
                        ZonaIntegritasPengaduan::STATUS_INVESTIGASI => 'warning',
                        ZonaIntegritasPengaduan::STATUS_SELESAI => 'success',
                        ZonaIntegritasPengaduan::STATUS_DITOLAK => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(ZonaIntegritasPengaduan::STATUS_OPTIONS),
                SelectFilter::make('jenis_pengaduan')
                    ->label('Jenis Pengaduan')
                    ->options(ZonaIntegritasPengaduan::JENIS_PENGADUAN_OPTIONS),
            ])
            ->recordActions([
                Action::make('download_bukti')
                    ->label('Bukti')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (ZonaIntegritasPengaduan $record): string => route('zona-integritas.pengaduan.bukti.download', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (ZonaIntegritasPengaduan $record): bool => filled($record->bukti_dukung_path)),
                Action::make('download_hasil')
                    ->label('Hasil')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (ZonaIntegritasPengaduan $record): string => route('zona-integritas.pengaduan.hasil.download', $record->nomor_pengaduan))
                    ->openUrlInNewTab()
                    ->visible(fn (ZonaIntegritasPengaduan $record): bool => filled($record->dokumen_hasil_path)),
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
            'index' => ListZonaIntegritasPengaduans::route('/'),
            'edit' => EditZonaIntegritasPengaduan::route('/{record}/edit'),
        ];
    }
}
