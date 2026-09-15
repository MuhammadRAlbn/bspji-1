<?php

namespace App\Jobs;

use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendWhatsappNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Jumlah toleransi percobaan ulang jika gateway timeout/error.
     */
    public int $tries = 3;

    /**
     * Jeda antar percobaan dalam detik (backoff bertingkat).
     *
     * @var array<int, int>|int
     */
    public array|int $backoff = [10, 30, 60];

    public function __construct(
        public string $phoneNumber,
        public string $message,
    ) {}

    public function handle(WhatsappService $whatsappService): void
    {
        $whatsappService->sendText($this->phoneNumber, $this->message);
    }

    public function failed(?Throwable $exception): void
    {
        Log::error('SendWhatsappNotificationJob gagal permanen setelah retry', [
            'phone' => $this->phoneNumber,
            'error' => $exception?->getMessage(),
        ]);
    }
}
