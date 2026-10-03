<?php

namespace App\Filament\Concerns;

use App\Services\AccountSessionService;
use Filament\Facades\Filament;

trait RechecksPanelAccess
{
    public function hydrate(): void
    {
        $user = app(AccountSessionService::class)->ensureCurrent(Filament::auth()->user(), Filament::getAuthGuard());
        abort_unless($user?->canAccessPanel(Filament::getCurrentOrDefaultPanel()), 403);
        Filament::auth()->setUser($user);
        static::authorizeResourceAccess();

        if (method_exists($this, 'authorizeAccess')) {
            $this->authorizeAccess();
        }
    }
}
