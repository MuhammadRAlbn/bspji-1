<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZonaIntegritasPengaduanRequest;
use App\Models\ZonaIntegritasPengaduan;
use App\Services\ZonaIntegritasPengaduanNumberGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ZonaIntegritasPengaduanController extends Controller
{
    public function store(
        StoreZonaIntegritasPengaduanRequest $request,
        ZonaIntegritasPengaduanNumberGenerator $numberGenerator,
    ): RedirectResponse {
        $data = $request->validated();
        $uploadedFile = $request->file('bukti_dukung');

        $pengaduan = DB::transaction(function () use ($data, $uploadedFile, $numberGenerator): ZonaIntegritasPengaduan {
            $number = $numberGenerator->next();

            $buktiPath = $uploadedFile
                ? $uploadedFile->store('zona-integritas/pengaduan/bukti', 'local')
                : null;

            return ZonaIntegritasPengaduan::create([
                ...$number,
                'nama' => $data['nama'],
                'jenis_pengaduan' => $data['jenis_pengaduan'],
                'jenis_pelanggan' => $data['jenis_pelanggan'],
                'nama_dilaporkan' => $data['nama_dilaporkan'],
                'judul' => $data['judul'],
                'uraian' => $data['uraian'],
                'bukti_dukung_path' => $buktiPath,
                'bukti_dukung_nama' => $uploadedFile?->getClientOriginalName(),
                'status' => ZonaIntegritasPengaduan::STATUS_DITERIMA,
            ]);
        });

        return redirect()
            ->route('zona-integritas.index', ['tab' => 'pengaduan'])
            ->with('pengaduan_success_nomor', $pengaduan->nomor_pengaduan);
    }

    public function downloadHasil(ZonaIntegritasPengaduan $pengaduan): BinaryFileResponse
    {
        abort_unless($pengaduan->dokumen_hasil_path, 404);
        abort_unless(Storage::disk('local')->exists($pengaduan->dokumen_hasil_path), 404);

        $path = Storage::disk('local')->path($pengaduan->dokumen_hasil_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
        $filename = $pengaduan->dokumen_hasil_nama
            ?: ((Str::slug('hasil '.$pengaduan->nomor_pengaduan) ?: 'hasil-pengaduan').'.'.$extension);

        return response()->download($path, $filename);
    }

    public function downloadBukti(ZonaIntegritasPengaduan $pengaduan): BinaryFileResponse
    {
        abort_unless($pengaduan->bukti_dukung_path, 404);
        abort_unless(Storage::disk('local')->exists($pengaduan->bukti_dukung_path), 404);

        $path = Storage::disk('local')->path($pengaduan->bukti_dukung_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
        $filename = $pengaduan->bukti_dukung_nama
            ?: ((Str::slug('bukti '.$pengaduan->nomor_pengaduan) ?: 'bukti-pengaduan').'.'.$extension);

        return response()->download($path, $filename);
    }
}
