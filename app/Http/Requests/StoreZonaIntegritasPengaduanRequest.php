<?php

namespace App\Http\Requests;

use App\Models\ZonaIntegritasPengaduan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreZonaIntegritasPengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jenis_pengaduan' => ['required', 'string', Rule::in(array_keys(ZonaIntegritasPengaduan::JENIS_PENGADUAN_OPTIONS))],
            'jenis_pelanggan' => ['required', 'string', Rule::in(array_keys(ZonaIntegritasPengaduan::JENIS_PELANGGARAN_OPTIONS))],
            'nama_dilaporkan' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
            'uraian' => ['required', 'string', 'min:10', 'max:5000'],
            'bukti_dukung' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'jenis_pelanggan' => 'jenis pelanggaran',
        ];
    }
}
