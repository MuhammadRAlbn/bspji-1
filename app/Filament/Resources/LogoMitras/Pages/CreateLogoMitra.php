<?php

namespace App\Filament\Resources\LogoMitras\Pages;

use App\Filament\Resources\LogoMitras\LogoMitraResource;
use App\Models\LogoMitra;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateLogoMitra extends CreateRecord
{
    protected static string $resource = LogoMitraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['tipe'] ?? null) === LogoMitra::TYPE_PELENGKAP && LogoMitra::query()->where('tipe', LogoMitra::TYPE_PELENGKAP)->exists()) {
            throw ValidationException::withMessages([
                'tipe' => 'Gambar pelengkap hanya boleh satu.',
            ]);
        }

        $data['singleton_key'] = ($data['tipe'] ?? null) === LogoMitra::TYPE_PELENGKAP ? 'pelengkap' : null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
