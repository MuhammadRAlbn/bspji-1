<?php

namespace App\Http\Responses;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class AdminLoginResponse extends LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        if (Filament::auth()->user()?->isPengaduanStaff()) {
            $request->session()->forget('url.intended');

            return redirect()->to(ZonaIntegritasPengaduanResource::getUrl('index'));
        }

        return parent::toResponse($request);
    }
}
