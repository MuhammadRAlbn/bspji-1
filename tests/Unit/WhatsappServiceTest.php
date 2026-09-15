<?php

namespace Tests\Unit;

use App\Services\WhatsappService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class WhatsappServiceTest extends TestCase
{
    private WhatsappService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
        Config::set('services.whatsapp.api_id', 'test_id');
        Config::set('services.whatsapp.api_key', 'test_key');

        $this->service = new WhatsappService;
    }

    public function test_normalizes_phone_numbers_correctly(): void
    {
        $this->assertSame('628123456789', $this->service->normalizePhoneNumber('08123456789'));
        $this->assertSame('628123456789', $this->service->normalizePhoneNumber('628123456789'));
        $this->assertSame('628123456789', $this->service->normalizePhoneNumber('+62 812-3456-789'));
        $this->assertSame('628123456789', $this->service->normalizePhoneNumber('8123456789'));
    }

    public function test_sends_form_post_request_to_otomat_gateway(): void
    {
        Config::set('services.whatsapp.enabled', true);
        Config::set('services.whatsapp.base_url', 'https://wa2.otomat.web.id');
        Config::set('services.whatsapp.api_key', 'test_key');

        Http::fake([
            'https://wa2.otomat.web.id' => Http::response('SUCCESS', 200),
        ]);

        $result = $this->service->sendText('08123456789', 'Halo ini pesan tes');

        $this->assertTrue($result['success']);
        $this->assertSame('SUCCESS', $result['response']);

        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://wa2.otomat.web.id'
                && $request->isForm()
                && $request['api_id'] === 'test_id'
                && $request['api_key'] === 'test_key'
                && $request['phone'] === '628123456789'
                && $request['text'] === 'Halo ini pesan tes';
        });
    }

    public function test_skips_sending_when_disabled_in_config(): void
    {
        Config::set('services.whatsapp.enabled', false);
        Http::fake();

        $result = $this->service->sendText('08123456789', 'Pesan');

        $this->assertFalse($result['success']);
        Http::assertNothingSent();
    }

    public function test_throws_exception_when_gateway_fails(): void
    {
        Config::set('services.whatsapp.enabled', true);
        Config::set('services.whatsapp.base_url', 'https://wa2.otomat.web.id');

        Http::fake([
            'https://wa2.otomat.web.id' => Http::response('Internal Server Error', 500),
        ]);

        $this->expectException(RuntimeException::class);
        $this->service->sendText('08123456789', 'Pesan');
    }
}
