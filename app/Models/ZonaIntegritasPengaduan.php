<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ZonaIntegritasPengaduan extends Model
{
    public const JENIS_PENGADUAN = 'pengaduan';

    public const JENIS_WBS = 'wbs';

    public const STATUS_DITERIMA = 'pengaduan_diterima';

    public const STATUS_INVESTIGASI = 'verifikasi_laporan_dan_proses_investigasi';

    public const STATUS_SELESAI = 'pengaduan_selesai';

    public const STATUS_DITOLAK = 'pengaduan_ditolak';

    public const JENIS_PENGADUAN_OPTIONS = [
        self::JENIS_PENGADUAN => 'Pengaduan',
        self::JENIS_WBS => 'WBS',
    ];

    public const JENIS_PELANGGARAN_OPTIONS = [
        'pelanggaran-peraturan' => 'Pelanggaran terhadap peraturan',
        'penyalahgunaan-wewenang' => 'Penyalahgunaan wewenang atau jabatan',
        'pelanggaran-kode-etik' => 'Pelanggaran kode etik',
        'membahayakan-k3-keamanan-organisasi' => 'Perbuatan yang membahayakan K3 atau keamanan organisasi',
        'kerugian-kemenperin-bspji' => 'Perbuatan yang dapat menimbulkan kerugian Kemenperin/BSPJI Banda Aceh',
        'pelanggaran-sop' => 'Pelanggaran terhadap SOP',
    ];

    public const JENIS_PELANGGAN_OPTIONS = self::JENIS_PELANGGARAN_OPTIONS;

    public const STATUS_OPTIONS = [
        self::STATUS_DITERIMA => 'Pengaduan diterima',
        self::STATUS_INVESTIGASI => 'Verifikasi laporan dan proses investigasi',
        self::STATUS_SELESAI => 'Pengaduan selesai',
        self::STATUS_DITOLAK => 'Pengaduan ditolak',
    ];

    /** @var array<int, string> */
    protected $fillable = [
        'nomor_pengaduan',
        'tahun_pengaduan',
        'sequence',
        'nama',
        'jenis_pengaduan',
        'jenis_pelanggan',
        'nama_dilaporkan',
        'judul',
        'uraian',
        'bukti_dukung_path',
        'bukti_dukung_nama',
        'status',
        'hasil_teks',
        'dokumen_hasil_path',
        'dokumen_hasil_nama',
        'selesai_at',
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        'status' => self::STATUS_DITERIMA,
    ];

    protected static function booted(): void
    {
        static::saving(function (self $pengaduan): void {
            if (
                $pengaduan->status === self::STATUS_SELESAI
                && blank($pengaduan->hasil_teks)
                && blank($pengaduan->dokumen_hasil_path)
            ) {
                throw ValidationException::withMessages([
                    'hasil_teks' => 'Isi hasil pengaduan atau unggah dokumen hasil sebelum menandai pengaduan selesai.',
                ]);
            }

            if ($pengaduan->status === self::STATUS_SELESAI && ! $pengaduan->selesai_at) {
                $pengaduan->selesai_at = now();
            }
        });
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('created_at')->orderByDesc('id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_OPTIONS[$this->status] ?? $this->status;
    }

    public function getJenisPengaduanLabelAttribute(): string
    {
        return self::JENIS_PENGADUAN_OPTIONS[$this->jenis_pengaduan] ?? $this->jenis_pengaduan;
    }

    public function getJenisPelangganLabelAttribute(): string
    {
        return self::JENIS_PELANGGARAN_OPTIONS[$this->jenis_pelanggan] ?? $this->jenis_pelanggan;
    }

    public function getJenisPelanggaranLabelAttribute(): string
    {
        return $this->jenis_pelanggan_label;
    }

    protected function casts(): array
    {
        return [
            'selesai_at' => 'datetime',
        ];
    }
}
