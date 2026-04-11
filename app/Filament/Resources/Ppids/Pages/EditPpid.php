<?php

namespace App\Filament\Resources\Ppids\Pages;

use App\Filament\Resources\Ppids\PpidResource;
use App\Models\Ppid;
use Filament\Resources\Pages\EditRecord;

class EditPpid extends EditRecord
{
    protected static string $resource = PpidResource::class;

    public function mount($record = null): void
    {
        $ppid = Ppid::first();

        if (! $ppid) {
            $ppid = Ppid::create([
                'structure_image' => null,
                'pdf_file' => null,
            ]);
        }

        parent::mount($ppid->id);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
