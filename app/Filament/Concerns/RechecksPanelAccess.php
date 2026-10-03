<?php

namespace App\Filament\Concerns;

use Filament\Facades\Filament;

trait RechecksPanelAccess
{
    public function hydrate(): void
    {
        $user = Filament::auth()->user()?->fresh();
        abort_unless($user?->canAccessPanel(Filament::getCurrentOrDefaultPanel()), 403);
        Filament::auth()->setUser($user);
        static::authorizeResourceAccess();

        if (method_exists($this, 'authorizeAccess')) {
            $this->authorizeAccess();
        }
    }
}
