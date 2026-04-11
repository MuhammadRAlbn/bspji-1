<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailInformasi extends Model
{
    protected $fillable = [
        'tipe',
        'kategori_id',
        'judul',
        'pdf_file',
        'keterangan',
        'urutan',
    ];

    public const KATEGORI_BERKALA = [
        'profil' => 'Profil',
        'dipa' => 'DIPA',
        'rka_kl' => 'RKA-K/L',
        'renstra' => 'Renstra',
        'kak' => 'KAK',
        'laporan_akuntabilitas' => 'Laporan Akuntabilitas',
        'renkin' => 'Renkin',
        'anggaran_program_kegiatan' => 'Anggaran Program dan Kegiatan',
        'ringkasan_informasi' => 'Ringkasan Informasi Program dan Kegiatan',
        'perjanjian_kinerja' => 'Perjanjian Kinerja',
        'laporan_keuangan' => 'Laporan Keuangan',
        'laporan_bmn' => 'Laporan BMN',
        'laporan_informasi_publik' => 'Laporan Informasi Publik',
        'laporan_pp39' => 'Laporan PP 39',
        'laporan_pengadaan' => 'Laporan Pengadaan Barang dan Jasa',
        'lhkpn' => 'LHKPN',
        'dasar_hukum_tarif' => 'Dasar Hukum Tarif Layanan',
        'laporan_kepegawaian' => 'Laporan Kepegawaian',
        'data_kepegawaian' => 'Data Kepegawaian',
        'peraturan' => 'Peraturan',
    ];

    public const KATEGORI_SETIAP_SAAT = [
        'data_statistik' => 'Data Statistik',
        'prosedur_peringatan_dini' => 'Prosedur Peringatan Dini dan Evakuasi Keadaan Darurat',
        'laporan_kepuasan_pelanggan' => 'Laporan Kepuasan Pelanggan',
        'rekapitulasi_keluhan' => 'Rekapitulasi Keluhan Pelanggan',
    ];

    public const TIPE_OPTIONS = [
        'berkala' => 'Informasi Berkala',
        'setiap_saat' => 'Informasi Setiap Saat',
    ];

    /**
     * Get kategori options based on tipe.
     *
     * @return array<string, string>
     */
    public static function getKategoriByTipe(?string $tipe): array
    {
        return match ($tipe) {
            'berkala' => self::KATEGORI_BERKALA,
            'setiap_saat' => self::KATEGORI_SETIAP_SAAT,
            default => [],
        };
    }

    /**
     * Get the human-readable label for a kategori_id.
     */
    public function getKategoriLabelAttribute(): string
    {
        $allKategori = array_merge(self::KATEGORI_BERKALA, self::KATEGORI_SETIAP_SAAT);

        return $allKategori[$this->kategori_id] ?? $this->kategori_id;
    }
}
