<?php

namespace App\Filament\Resources\StrukturOrganisasis\Pages;

use App\Filament\Resources\StrukturOrganisasis\StrukturOrganisasiResource;
use App\Models\StrukturOrganisasi;
use Filament\Resources\Pages\EditRecord;

class EditStrukturOrganisasi extends EditRecord
{
    protected static string $resource = StrukturOrganisasiResource::class;

    public function mount($record = null): void
    {
        $strukturOrganisasi = StrukturOrganisasi::first();

        if (! $strukturOrganisasi) {
            $strukturOrganisasi = StrukturOrganisasi::create([
                'image_path' => null,
            ]);
        }

        parent::mount($strukturOrganisasi->id);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
