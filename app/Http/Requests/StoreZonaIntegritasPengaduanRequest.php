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
        $isKomplain = $this->input('jenis_pengaduan') === ZonaIntegritasPengaduan::JENIS_KOMPLAIN;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                Rule::requiredIf($isKomplain),
                'nullable',
                'email',
                'max:255',
            ],
            'telepon' => [
                Rule::requiredIf($isKomplain),
                'nullable',
                'string',
                'max:30',
            ],
            'jenis_pengaduan' => ['required', 'string', Rule::in(array_keys(ZonaIntegritasPengaduan::JENIS_PENGADUAN_OPTIONS))],
            'jenis_pelanggan' => [
                Rule::requiredIf(! $isKomplain),
                'nullable',
                'string',
                Rule::in(array_keys(ZonaIntegritasPengaduan::JENIS_PELANGGARAN_OPTIONS)),
            ],
            'nama_dilaporkan' => [
                Rule::requiredIf(! $isKomplain),
                'nullable',
                'string',
                'max:255',
            ],
            'judul' => ['required', 'string', 'max:255'],
            'uraian' => ['required', 'string', 'min:10', 'max:5000'],
            'bukti_dukung' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama pelapor wajib diisi.',
            'jenis_pengaduan.required' => 'Jenis laporan wajib dipilih.',
            'jenis_pengaduan.in' => 'Jenis laporan yang dipilih tidak valid.',
            'email.required' => 'Email pelapor wajib diisi untuk komplain layanan.',
            'email.email' => 'Format email pelapor tidak valid.',
            'telepon.required' => 'Nomor handphone / WhatsApp wajib diisi untuk komplain layanan.',
            'jenis_pelanggan.required' => 'Jenis pelanggaran wajib dipilih.',
            'nama_dilaporkan.required' => 'Nama pihak yang dilaporkan wajib diisi.',
            'judul.required' => 'Judul laporan wajib diisi.',
            'uraian.required' => 'Uraian laporan wajib diisi.',
            'uraian.min' => 'Uraian laporan minimal harus berisi :min karakter.',
            'uraian.max' => 'Uraian laporan maksimal :max karakter.',
            'bukti_dukung.max' => 'Ukuran file bukti dukung tidak boleh lebih dari 5 MB.',
            'bukti_dukung.mimes' => 'Format file bukti dukung harus berupa PDF, JPG, JPEG, atau PNG.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'jenis_pelanggan' => 'jenis pelanggaran',
            'nama_dilaporkan' => 'nama yang dilaporkan',
            'email' => 'email pelapor',
            'telepon' => 'nomor handphone / WhatsApp',
            'judul' => 'judul laporan',
            'uraian' => 'uraian laporan',
        ];
    }
}
