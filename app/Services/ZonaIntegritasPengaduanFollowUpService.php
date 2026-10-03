<?php

namespace App\Services;

use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ZonaIntegritasPengaduanFollowUpService
{
    public function update(User $actor, ZonaIntegritasPengaduan $record, array $data): ZonaIntegritasPengaduan
    {
        $uploadedPath = null;

        try {
            return DB::transaction(function () use ($actor, $record, $data, &$uploadedPath): ZonaIntegritasPengaduan {
                $current = ZonaIntegritasPengaduan::query()->lockForUpdate()->findOrFail($record->getKey());
                Gate::forUser($actor->fresh())->authorize('update', $current);
                $data = Validator::make(Arr::only($data, ['status', 'hasil_teks', 'dokumen_hasil_path']), [
                    'status' => ['required', Rule::in(array_keys(ZonaIntegritasPengaduan::STATUS_OPTIONS))],
                    'hasil_teks' => ['nullable', 'string'],
                    'dokumen_hasil_path' => ['nullable', function (string $attribute, mixed $value, \Closure $fail) use ($current): void {
                        if ($value instanceof UploadedFile) {
                            return;
                        }
                        if (! is_string($value) || $value !== $current->dokumen_hasil_path || ! Storage::disk('local')->exists($value)) {
                            $fail('Dokumen hasil harus berasal dari pengaduan ini atau unggahan baru yang valid.');
                        }
                    }],
                ])->validate();

                $document = array_key_exists('dokumen_hasil_path', $data) ? $data['dokumen_hasil_path'] : $current->dokumen_hasil_path;
                $text = trim($data['hasil_teks'] ?? '');
                $text = $text === '' ? null : $text;

                if ($document instanceof UploadedFile) {
                    Validator::make(['dokumen_hasil_path' => $document], ['dokumen_hasil_path' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']])->validate();
                }

                $hasDocument = $document instanceof UploadedFile || (is_string($document) && filled($document) && Storage::disk('local')->exists($document));
                if ($data['status'] === ZonaIntegritasPengaduan::STATUS_SELESAI && $text === null && ! $hasDocument) {
                    throw ValidationException::withMessages(['hasil_teks' => 'Isi hasil pengaduan atau unggah dokumen hasil sebelum menandai pengaduan selesai.']);
                }

                $name = $document ? $current->dokumen_hasil_nama : null;
                if ($document instanceof UploadedFile) {
                    $name = $document->getClientOriginalName();
                    $uploadedPath = $document->store('zona-integritas/pengaduan/hasil', 'local');
                    if (! $uploadedPath) {
                        throw ValidationException::withMessages(['dokumen_hasil_path' => 'Dokumen hasil tidak dapat disimpan. Silakan coba kembali.']);
                    }
                    $document = $uploadedPath;
                }

                $current->fill([
                    'status' => $data['status'], 'hasil_teks' => $text,
                    'dokumen_hasil_path' => $document, 'dokumen_hasil_nama' => $name,
                ])->save();

                return $current;
            });
        } catch (Throwable $exception) {
            if ($uploadedPath) {
                Storage::disk('local')->delete($uploadedPath);
            }

            throw $exception;
        }
    }
}
