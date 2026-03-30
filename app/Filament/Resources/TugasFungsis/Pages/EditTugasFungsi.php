<?php

namespace App\Filament\Resources\TugasFungsis\Pages;

use App\Filament\Resources\TugasFungsis\TugasFungsiResource;
use App\Models\TugasFungsi;
use Filament\Resources\Pages\EditRecord;

class EditTugasFungsi extends EditRecord
{
    protected static string $resource = TugasFungsiResource::class;

    public function mount($record = null): void
    {
        $tugasFungsi = TugasFungsi::first();

        if (! $tugasFungsi) {
            $tugasFungsi = TugasFungsi::create([
                'tugas' => '-',
                'fungsi' => '-',
            ]);
        }

        parent::mount($tugasFungsi->id);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
