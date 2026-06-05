<?php

namespace App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource\Pages;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use App\Models\ZonaIntegritasPengaduan;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;

class EditZonaIntegritasPengaduan extends EditRecord
{
    protected static string $resource = ZonaIntegritasPengaduanResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws Halt
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            ($data['status'] ?? null) === ZonaIntegritasPengaduan::STATUS_SELESAI
            && blank($data['hasil_teks'] ?? null)
            && blank($data['dokumen_hasil_path'] ?? $this->record->dokumen_hasil_path)
        ) {
            Notification::make()
                ->title('Hasil pengaduan belum lengkap')
                ->body('Isi keterangan hasil atau unggah dokumen hasil sebelum mengubah status menjadi Pengaduan selesai.')
                ->danger()
                ->send();

            throw (new Halt)->rollBackDatabaseTransaction();
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
