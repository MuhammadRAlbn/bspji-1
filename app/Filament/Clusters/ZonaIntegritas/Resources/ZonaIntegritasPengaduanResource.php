<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Actions\DeletePengaduanAction;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\EditZonaIntegritasPengaduan;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ListZonaIntegritasPengaduans;
use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages\ViewZonaIntegritasPengaduan;
use App\Filament\Clusters\ZonaIntegritas\ZonaIntegritasCluster;
use App\Models\ZonaIntegritasPengaduan;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
            TextInput::make('email')
                ->label('Email Pelapor')
                ->placeholder('-')
                ->disabled()
                ->dehydrated(false),
            TextInput::make('telepon')
                ->label('Nomor Handphone / WhatsApp')
                ->placeholder('-')
                ->disabled()
                ->dehydrated(false),
            TextInput::make('jenis_pengaduan')
                ->label('Jenis Pengaduan')
                ->formatStateUsing(fn (?ZonaIntegritasPengaduan $record): string => $record?->jenis_pengaduan_label ?? '-')
                ->disabled()
                ->dehydrated(false),
            TextInput::make('jenis_pelanggaran_label')
                ->label('Jenis Pelanggaran')
                ->formatStateUsing(fn (?ZonaIntegritasPengaduan $record): string => $record?->jenis_pelanggaran_label ?? '-')
                ->visible(fn (?ZonaIntegritasPengaduan $record): bool => $record?->jenis_pengaduan !== ZonaIntegritasPengaduan::JENIS_KOMPLAIN)
                ->disabled()
                ->dehydrated(false)
                ->columnSpanFull(),
            TextInput::make('nama_dilaporkan')
                ->label('Nama Yang Dilaporkan')
                ->visible(fn (?ZonaIntegritasPengaduan $record): bool => $record?->jenis_pengaduan !== ZonaIntegritasPengaduan::JENIS_KOMPLAIN)
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
                ->visibility('private')
                ->storeFiles(false)
                ->getUploadedFileUsing(function (?ZonaIntegritasPengaduan $record, string $file): ?array {
                    $record = $record?->fresh();
                    if (! $record || ! Gate::allows('view', $record) || $file !== $record->dokumen_hasil_path || ! Storage::disk('local')->exists($file)) {
                        return null;
                    }

                    return [
                        'name' => $record->dokumen_hasil_nama ?: basename($file),
                        'size' => Storage::disk('local')->size($file),
                        'type' => Storage::disk('local')->mimeType($file),
                        'url' => route('zona-integritas.pengaduan.hasil.download', $record->nomor_pengaduan),
                    ];
                })
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
            ->recordUrl(fn (ZonaIntegritasPengaduan $record): string => static::getUrl('view', ['record' => $record]))
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
                    ->badge()
                    ->color(fn (ZonaIntegritasPengaduan $record): string => match ($record->jenis_pengaduan) {
                        ZonaIntegritasPengaduan::JENIS_PENGADUAN => 'danger',
                        ZonaIntegritasPengaduan::JENIS_KOMPLAIN => 'warning',
                        ZonaIntegritasPengaduan::JENIS_WBS => 'info',
                        default => 'gray',
                    }),
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
                    ->authorize('view')
                    ->visible(fn (ZonaIntegritasPengaduan $record): bool => filled($record->bukti_dukung_path)),
                Action::make('download_hasil')
                    ->label('Hasil')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (ZonaIntegritasPengaduan $record): string => route('zona-integritas.pengaduan.hasil.download', $record->nomor_pengaduan))
                    ->openUrlInNewTab()
                    ->authorize('view')
                    ->visible(fn (ZonaIntegritasPengaduan $record): bool => filled($record->dokumen_hasil_path)),
                ViewAction::make()->label('Lihat'),
                EditAction::make(),
                DeletePengaduanAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListZonaIntegritasPengaduans::route('/'),
            'view' => ViewZonaIntegritasPengaduan::route('/{record}'),
            'edit' => EditZonaIntegritasPengaduan::route('/{record}/edit'),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pengaduan')->schema([
                TextEntry::make('nomor_pengaduan')->label('Nomor Pengaduan'),
                TextEntry::make('status_label')->label('Status')->badge(),
                TextEntry::make('jenis_pengaduan_label')->label('Jenis Pengaduan'),
                TextEntry::make('jenis_pelanggaran_label')->label('Jenis Pelanggaran')
                    ->visible(fn (ZonaIntegritasPengaduan $record): bool => $record->jenis_pengaduan !== ZonaIntegritasPengaduan::JENIS_KOMPLAIN),
                TextEntry::make('nama')->label('Nama Pelapor'),
                TextEntry::make('email')->label('Email Pelapor')->placeholder('-'),
                TextEntry::make('telepon')->label('Nomor Handphone / WhatsApp')->placeholder('-'),
                TextEntry::make('nama_dilaporkan')->label('Nama Yang Dilaporkan')->placeholder('-')
                    ->visible(fn (ZonaIntegritasPengaduan $record): bool => $record->jenis_pengaduan !== ZonaIntegritasPengaduan::JENIS_KOMPLAIN),
                TextEntry::make('judul')->label('Judul')->columnSpanFull(),
                TextEntry::make('uraian')->label('Uraian Pengaduan')->columnSpanFull(),
                Actions::make([
                    Action::make('download_bukti')->label('Unduh Bukti')->icon('heroicon-o-arrow-down-tray')
                        ->url(fn (ZonaIntegritasPengaduan $record): string => $record->trashed()
                            ? route('zona-integritas.pengaduan.riwayat.download', ['pengaduan' => $record, 'document' => 'bukti'])
                            : route('zona-integritas.pengaduan.bukti.download', $record))
                        ->openUrlInNewTab()->authorize(fn (ZonaIntegritasPengaduan $record): bool => Gate::allows($record->trashed() ? 'viewHistory' : 'view', $record))
                        ->visible(fn (ZonaIntegritasPengaduan $record): bool => filled($record->bukti_dukung_path)),
                ])->columnSpanFull(),
            ])->columns(2)->columnSpanFull(),
            Section::make('Tindak Lanjut')->schema([
                TextEntry::make('hasil_teks')->label('Hasil Pengaduan')->placeholder('Belum ada hasil tindak lanjut.')->columnSpanFull(),
                Actions::make([
                    Action::make('download_hasil')->label('Unduh Dokumen Hasil')->icon('heroicon-o-document-arrow-down')
                        ->url(fn (ZonaIntegritasPengaduan $record): string => $record->trashed()
                            ? route('zona-integritas.pengaduan.riwayat.download', ['pengaduan' => $record, 'document' => 'hasil'])
                            : route('zona-integritas.pengaduan.hasil.download', $record->nomor_pengaduan))
                        ->openUrlInNewTab()->authorize(fn (ZonaIntegritasPengaduan $record): bool => Gate::allows($record->trashed() ? 'viewHistory' : 'view', $record))
                        ->visible(fn (ZonaIntegritasPengaduan $record): bool => filled($record->dokumen_hasil_path)),
                ])->columnSpanFull(),
                TextEntry::make('created_at')->label('Dikirim')->dateTime(),
                TextEntry::make('updated_at')->label('Terakhir Diubah')->dateTime(),
                TextEntry::make('selesai_at')->label('Selesai')->dateTime()->placeholder('-'),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
