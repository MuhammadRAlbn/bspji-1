<?php

namespace App\Http\Controllers;

use App\Models\ZonaIntegritasDokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ZonaIntegritasDokumenController extends Controller
{
    public function download(ZonaIntegritasDokumen $dokumen): BinaryFileResponse
    {
        abort_unless($dokumen->is_active, 404);
        abort_unless(Storage::disk('public')->exists($dokumen->file_path), 404);

        $path = Storage::disk('public')->path($dokumen->file_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
        $filename = (Str::slug($dokumen->nama_dokumen) ?: 'dokumen-zona-integritas').'.'.$extension;

        return response()->download($path, $filename);
    }
}
