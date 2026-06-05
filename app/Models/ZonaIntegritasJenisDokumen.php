<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZonaIntegritasJenisDokumen extends Model
{
    public const KODE_ZONA_INTEGRITAS = 'zona-integritas';

    public const KODE_IKM_LAPORAN = 'ikm-laporan';

    public const KODE_INDEKS_PERSEPSI_KORUPSI = 'indeks-persepsi-korupsi';

    public const KODE_PENGADUAN_LAPORAN = 'pengaduan-laporan';

    public const KODE_BENTURAN_KEPENTINGAN = 'benturan-kepentingan';

    public const KODE_BENTURAN_LAPORAN = 'benturan-laporan';

    public const KODE_GRATIFIKASI_LAPORAN = 'gratifikasi-laporan';

    public const KODE_WBS_LAPORAN = 'wbs-laporan';

    public const KODE_DOKUMEN = [
        self::KODE_ZONA_INTEGRITAS,
        self::KODE_IKM_LAPORAN,
        self::KODE_INDEKS_PERSEPSI_KORUPSI,
        self::KODE_PENGADUAN_LAPORAN,
        self::KODE_BENTURAN_KEPENTINGAN,
        self::KODE_BENTURAN_LAPORAN,
        self::KODE_GRATIFIKASI_LAPORAN,
        self::KODE_WBS_LAPORAN,
    ];

    public const LABELS = [
        self::KODE_ZONA_INTEGRITAS => 'Zona Integritas',
        self::KODE_IKM_LAPORAN => 'Laporan IKM',
        self::KODE_INDEKS_PERSEPSI_KORUPSI => 'Indeks Persepsi Korupsi',
        self::KODE_PENGADUAN_LAPORAN => 'Laporan Pelaksanaan Pengaduan',
        self::KODE_BENTURAN_KEPENTINGAN => 'Benturan Kepentingan',
        self::KODE_BENTURAN_LAPORAN => 'Laporan Pelaksanaan Benturan Kepentingan',
        self::KODE_GRATIFIKASI_LAPORAN => 'Laporan Pelaksanaan Gratifikasi',
        self::KODE_WBS_LAPORAN => 'Laporan Pelaksanaan WBS',
    ];

    /** @var array<int, string> */
    protected $fillable = [
        'kode',
        'nama',
        'urutan',
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        'urutan' => 0,
    ];

    public function dokumens(): HasMany
    {
        return $this->hasMany(ZonaIntegritasDokumen::class, 'jenis_dokumen_id');
    }
}
