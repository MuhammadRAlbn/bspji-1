<?php

namespace App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\Pages;

use App\Filament\Clusters\InformasiPublik\Resources\DaftarInformasiPubliks\DaftarInformasiPublikResource;
use App\Models\DaftarInformasiPublik;
use Filament\Resources\Pages\EditRecord;

class EditDaftarInformasiPublik extends EditRecord
{
    protected static string $resource = DaftarInformasiPublikResource::class;

    public function mount($record = null): void
    {
        $daftarInformasiPublik = DaftarInformasiPublik::first();

        if (! $daftarInformasiPublik) {
            $daftarInformasiPublik = DaftarInformasiPublik::create([
                'pdf_file' => null,
            ]);
        }

        parent::mount($daftarInformasiPublik->id);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
