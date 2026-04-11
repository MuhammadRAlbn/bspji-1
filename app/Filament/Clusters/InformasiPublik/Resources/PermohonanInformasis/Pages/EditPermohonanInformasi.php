<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\Pages;

use App\Filament\Clusters\InformasiPublik\Resources\PermohonanInformasis\PermohonanInformasiResource;
use App\Models\PermohonanInformasi;
use Filament\Resources\Pages\EditRecord;

class EditPermohonanInformasi extends EditRecord
{
    protected static string $resource = PermohonanInformasiResource::class;

    public function mount($record = null): void
    {
        $permohonanInformasi = PermohonanInformasi::first();

        if (! $permohonanInformasi) {
            $permohonanInformasi = PermohonanInformasi::create([
                'form_image' => null,
                'pdf_file' => null,
            ]);
        }

        parent::mount($permohonanInformasi->id);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
