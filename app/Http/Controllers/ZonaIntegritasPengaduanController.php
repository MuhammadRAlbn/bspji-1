<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZonaIntegritasPengaduanRequest;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\ZonaIntegritasPengaduanNotificationService;
use App\Services\ZonaIntegritasPengaduanNumberGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ZonaIntegritasPengaduanController extends Controller
{
    public function store(
        StoreZonaIntegritasPengaduanRequest $request,
        ZonaIntegritasPengaduanNumberGenerator $numberGenerator,
        ZonaIntegritasPengaduanNotificationService $notificationService,
    ): RedirectResponse {
        $data = $request->validated();
        $uploadedFile = $request->file('bukti_dukung');

        $pengaduan = DB::transaction(function () use ($data, $uploadedFile, $numberGenerator): ZonaIntegritasPengaduan {
            $number = $numberGenerator->next();

            $buktiPath = $uploadedFile
                ? $uploadedFile->store('zona-integritas/pengaduan/bukti', 'local')
                : null;

            $isKomplain = $data['jenis_pengaduan'] === ZonaIntegritasPengaduan::JENIS_KOMPLAIN;

            return ZonaIntegritasPengaduan::create([
                ...$number,
                'nama' => $data['nama'],
                'email' => $data['email'] ?? null,
                'telepon' => $data['telepon'] ?? null,
                'jenis_pengaduan' => $data['jenis_pengaduan'],
                'jenis_pelanggan' => $isKomplain ? null : ($data['jenis_pelanggan'] ?? null),
                'nama_dilaporkan' => $isKomplain ? null : ($data['nama_dilaporkan'] ?? null),
                'judul' => $data['judul'],
                'uraian' => $data['uraian'],
                'bukti_dukung_path' => $buktiPath,
                'bukti_dukung_nama' => $uploadedFile?->getClientOriginalName(),
                'status' => ZonaIntegritasPengaduan::STATUS_DITERIMA,
            ]);
        });

        $notificationService->notifyNewSubmission($pengaduan);

        return redirect()
            ->route('zona-integritas.index', ['tab' => 'pengaduan'])
            ->with('pengaduan_success_nomor', $pengaduan->nomor_pengaduan);
    }

    public function downloadHasil(ZonaIntegritasPengaduan $pengaduan): BinaryFileResponse
    {
        return $this->downloadDocument($pengaduan, 'hasil');
    }

    public function downloadBukti(ZonaIntegritasPengaduan $pengaduan): BinaryFileResponse
    {
        Gate::authorize('view', $pengaduan);

        return $this->downloadDocument($pengaduan, 'bukti');
    }

    public function downloadHistoryDocument(ZonaIntegritasPengaduan $pengaduan, string $document): BinaryFileResponse
    {
        abort_unless($pengaduan->trashed() && in_array($document, ['bukti', 'hasil'], true), 404);
        Gate::authorize('viewHistory', $pengaduan);

        return $this->downloadDocument($pengaduan, $document);
    }

    private function downloadDocument(ZonaIntegritasPengaduan $pengaduan, string $document): BinaryFileResponse
    {
        [$storedPath, $storedName] = $document === 'bukti'
            ? [$pengaduan->bukti_dukung_path, $pengaduan->bukti_dukung_nama]
            : [$pengaduan->dokumen_hasil_path, $pengaduan->dokumen_hasil_nama];
        abort_unless($storedPath && Storage::disk('local')->exists($storedPath), 404);

        $path = Storage::disk('local')->path($storedPath);
        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
        $filename = $storedName
            ?: ((Str::slug($document.' '.$pengaduan->nomor_pengaduan) ?: $document.'-pengaduan').'.'.$extension);

        return response()->download($path, $filename);
    }
}
