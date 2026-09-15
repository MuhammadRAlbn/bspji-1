<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class WhatsappService
{
    /**
     * Kirim pesan teks ke nomor WhatsApp tujuan via gateway Otomat.
     *
     * @return array{success: bool, response?: string, message?: string}
     */
    public function sendText(string $phoneNumber, string $message): array
    {
        $config = config('services.whatsapp');

        if (! ($config['enabled'] ?? true)) {
            Log::info('WhatsApp gateway dilewati: layanan dinonaktifkan di konfigurasi.');

            return [
                'success' => false,
                'message' => 'WhatsApp gateway disabled by config.',
            ];
        }

        $normalizedPhone = $this->normalizePhoneNumber($phoneNumber);

        $payload = [
            'api_id' => (string) ($config['api_id'] ?? ''),
            'api_key' => (string) ($config['api_key'] ?? ''),
            'phone' => $normalizedPhone,
            'text' => $message,
        ];

        try {
            $response = Http::asForm()
                ->timeout((int) ($config['timeout'] ?? 20))
                ->post((string) ($config['base_url'] ?? ''), $payload)
                ->throw();

            Log::info('WhatsApp gateway request sent successfully', [
                'phone' => $normalizedPhone,
                'response' => $response->body(),
            ]);

            return [
                'success' => true,
                'response' => $response->body(),
            ];
        } catch (RequestException $exception) {
            Log::error('WhatsApp gateway request failed', [
                'phone' => $normalizedPhone,
                'error' => $exception->getMessage(),
                'response' => $exception->response?->body(),
            ]);

            throw new RuntimeException(
                $exception->response?->body() ?: $exception->getMessage(),
                previous: $exception
            );
        }
    }

    /**
     * Menormalkan nomor telepon ke format standar internasional Indonesia (628xxx).
     */
    public function normalizePhoneNumber(string $phoneNumber): string
    {
        $normalized = preg_replace('/[^0-9]/', '', $phoneNumber) ?? '';

        if (str_starts_with($normalized, '0')) {
            return '62'.substr($normalized, 1);
        }

        if (! str_starts_with($normalized, '62')) {
            return '62'.ltrim($normalized, '0');
        }

        return $normalized;
    }
}
