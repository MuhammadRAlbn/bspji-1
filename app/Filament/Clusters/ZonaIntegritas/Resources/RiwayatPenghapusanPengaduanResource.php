<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources;

use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages\ListRiwayatPenghapusanPengaduans;
use App\Filament\Clusters\ZonaIntegritas\Resources\RiwayatPenghapusanPengaduanResource\Pages\ViewRiwayatPenghapusanPengaduan;
use App\Models\ZonaIntegritasPengaduan;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenghapusanPengaduanResource extends ZonaIntegritasPengaduanResource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $navigationLabel = 'Riwayat Penghapusan';

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Riwayat Penghapusan Pengaduan';

    protected static ?string $pluralModelLabel = 'Riwayat Penghapusan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->onlyTrashed();
    }

    public static function getViewAnyAuthorizationResponse(): Response
    {
        return static::getAuthorizationResponse('viewHistoryAny');
    }

    public static function getViewAuthorizationResponse(Model $record): Response
    {
        return static::getAuthorizationResponse('viewHistory', $record);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort(fn (Builder $query): Builder => $query->orderByDesc('deleted_at')->orderByDesc('id'))
            ->recordUrl(fn (ZonaIntegritasPengaduan $record): string => static::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('nomor_pengaduan')->label('Nomor')->searchable(),
                TextColumn::make('judul')->label('Judul')->searchable()->limit(40)->wrap(),
                TextColumn::make('deleted_by_name')->label('Dihapus Oleh')->searchable()->wrap(),
                TextColumn::make('deleted_at')->label('Waktu Penghapusan')->dateTime('d/m/Y H:i:s')->sortable(),
                TextColumn::make('deletion_reason')->label('Alasan Penghapusan')->searchable()->limit(60)->wrap(),
            ])
            ->recordActions([ViewAction::make()->label('Lihat')])
            ->toolbarActions([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        $schema = parent::infolist($schema);

        return $schema->components([
            Section::make('Catatan Penghapusan')->schema([
                TextEntry::make('deleted_at')->label('Waktu Penghapusan')->dateTime(),
                TextEntry::make('deleted_by_name')->label('Dihapus Oleh'),
                TextEntry::make('deleted_by_email')->label('Email Admin Saat Penghapusan'),
                TextEntry::make('deleted_by_id')->label('ID Akun Admin'),
                TextEntry::make('deletion_reason')->label('Alasan Penghapusan')->columnSpanFull(),
            ])->columns(2)->columnSpanFull(),
            ...$schema->getComponents(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRiwayatPenghapusanPengaduans::route('/'),
            'view' => ViewRiwayatPenghapusanPengaduan::route('/{record}'),
        ];
    }
}
