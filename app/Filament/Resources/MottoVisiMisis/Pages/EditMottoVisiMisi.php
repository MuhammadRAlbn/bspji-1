<?php

namespace App\Filament\Resources\MottoVisiMisis\Pages;

use App\Filament\Resources\MottoVisiMisis\MottoVisiMisiResource;
use App\Models\MottoVisiMisi;
use Filament\Resources\Pages\EditRecord;

class EditMottoVisiMisi extends EditRecord
{
    protected static string $resource = MottoVisiMisiResource::class;

    public function mount($record = null): void
    {
        $motto = MottoVisiMisi::first();

        if (! $motto) {
            $motto = MottoVisiMisi::create([
                'visi' => '-',
                'misi' => '-',
            ]);
        }

        parent::mount($motto->id);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
