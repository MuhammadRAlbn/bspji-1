<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Actions;

use App\Models\ZonaIntegritasPengaduan;
use App\Services\ZonaIntegritasPengaduanDeletionService;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;

class DeletePengaduanAction extends DeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Hapus')
            ->hidden(fn (?ZonaIntegritasPengaduan $record): bool => $record === null || $record->trashed())
            ->modalHeading('Hapus Pengaduan Ditolak')
            ->modalDescription(fn (ZonaIntegritasPengaduan $record): string => "Pengaduan {$record->nomor_pengaduan} akan dikeluarkan dari daftar aktif. Laporan dan lampiran tetap tersimpan di Riwayat Penghapusan.")
            ->modalSubmitActionLabel('Hapus Pengaduan')
            ->schema([
                Textarea::make('deletion_reason')
                    ->label('Alasan Penghapusan')
                    ->helperText('Jelaskan alasan pengaduan ditolak dan perlu dihapus dari daftar.')
                    ->required()
                    ->rules(['string'])
                    ->maxLength(2000)
                    ->rows(4)
                    ->dehydrateStateUsing(fn (mixed $state): mixed => is_string($state) ? Str::trim($state) : $state),
            ])
            ->successNotificationTitle('Pengaduan dihapus dan tersimpan di riwayat')
            ->using(fn (ZonaIntegritasPengaduan $record, array $data): bool => app(ZonaIntegritasPengaduanDeletionService::class)->delete(Filament::auth()->user(), $record, $data));
    }
}
