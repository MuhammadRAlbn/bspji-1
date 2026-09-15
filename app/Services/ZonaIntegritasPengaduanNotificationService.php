<?php

namespace App\Services;

use App\Jobs\SendWhatsappNotificationJob;
use App\Models\ZonaIntegritasPengaduan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ZonaIntegritasPengaduanNotificationService
{
    /**
     * Kirim notifikasi pengaduan baru ke seluruh penerima yang terdaftar.
     */
    public function notifyNewSubmission(ZonaIntegritasPengaduan $pengaduan): void
    {
        try {
            $recipients = $this->getRecipients();

            if (empty($recipients)) {
                Log::info('Notifikasi WhatsApp pengaduan dilewati: tidak ada nomor penerima yang terkonfigurasi.');

                return;
            }

            $message = $this->buildMessage($pengaduan);

            foreach ($recipients as $recipient) {
                SendWhatsappNotificationJob::dispatch($recipient, $message);
            }

            Log::info('Job notifikasi WhatsApp pengaduan berhasil didispatch', [
                'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                'total_recipients' => count($recipients),
            ]);
        } catch (Throwable $exception) {
            Log::error('Gagal mengirimkan notifikasi WhatsApp pengaduan Zona Integritas', [
                'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Bangun pesan teks notifikasi WhatsApp yang informatif dan terstruktur.
     */
    public function buildMessage(ZonaIntegritasPengaduan $pengaduan): string
    {
        $waktu = ($pengaduan->created_at ?? now())->copy()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i').' WIB';

        $pesan = "📢 *NOTIFIKASI PENGADUAN BARU*\n"
            ."Zona Integritas - Website\n\n"
            ."*Nomor Tiket:* #{$pengaduan->nomor_pengaduan}\n"
            ."*Jenis Laporan:* {$pengaduan->jenis_pengaduan_label}\n"
            ."*Waktu Masuk:* {$waktu}\n\n";

        if ($pengaduan->jenis_pengaduan === ZonaIntegritasPengaduan::JENIS_KOMPLAIN) {
            $pesan .= "👤 *Pengirim:*\n"
                ."• Nama: {$pengaduan->nama}\n"
                ."• Telepon/WA: ".($pengaduan->telepon ?: '-')."\n"
                ."• Email: ".($pengaduan->email ?: '-')."\n\n";
        } else {
            $pesan .= "👤 *Pelapor:* {$pengaduan->nama}\n";
            if ($pengaduan->telepon) {
                $pesan .= "• Telepon: {$pengaduan->telepon}\n";
            }
            if ($pengaduan->email) {
                $pesan .= "• Email: {$pengaduan->email}\n";
            }
            if ($pengaduan->nama_dilaporkan) {
                $pesan .= "• Pihak Terlapor: {$pengaduan->nama_dilaporkan}\n";
            }
            if ($pengaduan->jenis_pelanggan_label && $pengaduan->jenis_pelanggan_label !== '-') {
                $pesan .= "• Kategori: {$pengaduan->jenis_pelanggan_label}\n";
            }
            $pesan .= "\n";
        }

        $uraianCuplikan = Str::limit(strip_tags((string) $pengaduan->uraian), 200, '...');

        $pesan .= "*Judul:* {$pengaduan->judul}\n"
            ."*Uraian Ringkas:*\n_{$uraianCuplikan}_\n\n";

        $adminUrl = url('/admin/zona-integritas/zona-integritas-pengaduans/'.$pengaduan->id.'/edit');

        $pesan .= "🔗 *Buka di Panel Admin:*\n{$adminUrl}\n\n"
            .'_Pesan otomatis sistem BSPJI Banda Aceh._';

        return $pesan;
    }

    /**
     * Dapatkan daftar nomor telepon penerima yang valid dari konfigurasi.
     *
     * @return array<int, string>
     */
    public function getRecipients(): array
    {
        $recipients = config('services.whatsapp.recipients', []);

        if (is_string($recipients)) {
            $recipients = explode(',', $recipients);
        }

        return array_values(array_filter(array_map('trim', (array) $recipients)));
    }
}
