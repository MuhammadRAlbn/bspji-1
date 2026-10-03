<?php

namespace App\Services;

use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;

class ZonaIntegritasPengaduanDeletionService
{
    public function delete(User $actor, ZonaIntegritasPengaduan $record, array $data): bool
    {
        return DB::transaction(function () use ($actor, $record, $data): bool {
            $currentActor = User::query()->lockForUpdate()->find($actor->getKey());
            if (! $currentActor) {
                throw new AuthorizationException('Akun tidak lagi memiliki akses.');
            }

            $current = ZonaIntegritasPengaduan::query()->lockForUpdate()->findOrFail($record->getKey());
            Gate::forUser($currentActor)->authorize('delete', $current);

            $reason = $data['deletion_reason'] ?? null;
            $validated = Validator::make([
                'deletion_reason' => is_string($reason) ? Str::trim($reason) : $reason,
            ], [
                'deletion_reason' => ['required', 'string', 'max:2000'],
            ], [
                'deletion_reason.required' => 'Alasan penghapusan wajib diisi.',
                'deletion_reason.string' => 'Alasan penghapusan harus berupa teks.',
                'deletion_reason.max' => 'Alasan penghapusan maksimal 2.000 karakter.',
            ])->validate();

            $current->forceFill([
                'deletion_reason' => $validated['deletion_reason'],
                'deleted_by_id' => $currentActor->getKey(),
                'deleted_by_name' => $currentActor->name,
                'deleted_by_email' => $currentActor->email,
            ]);

            if (! $current->save() || ! $current->delete()) {
                throw new RuntimeException('Pengaduan dan riwayat penghapusannya tidak dapat disimpan.');
            }

            return true;
        });
    }
}
