<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class AccountSessionService
{
    public function initializeFromLogin(Login $event): void
    {
        if (! $event->user instanceof User || ! request()->hasSession()) {
            return;
        }

        $guard = Auth::guard($event->guard);
        $fingerprint = $guard->hashPasswordForCookie($event->user->getAuthPassword());
        $recaller = request()->cookie($guard->getRecallerName());
        if ($guard->viaRemember() && $guard->getLastAttempted() !== $event->user && is_string($recaller)) {
            $cookieFingerprint = explode('|', $recaller)[2] ?? '';
            if (! hash_equals($fingerprint, $cookieFingerprint)) {
                session()->forget($this->sessionKey($event->guard));

                return;
            }
        }

        session()->put($this->sessionKey($event->guard), $fingerprint);
    }

    public function ensureCurrent(?User $authenticatedUser, ?string $guardName = null): User
    {
        $guardName ??= Auth::getDefaultDriver();
        $user = $authenticatedUser?->fresh();
        if (! $user?->hasPanelAccess()) {
            $this->clearCurrent($guardName);
            abort(403);
        }
        $this->assertCredentials($user, $guardName);
        Auth::guard($guardName)->setUser($user);

        return $user;
    }

    public function assertCredentials(User $user, ?string $guardName = null): void
    {
        $guardName ??= Auth::getDefaultDriver();
        $guard = Auth::guard($guardName);
        $marker = session($this->sessionKey($guardName));
        if (is_string($marker) && hash_equals($guard->hashPasswordForCookie($user->getAuthPassword()), $marker)) {
            return;
        }

        $this->clearCurrent($guardName);

        throw new AuthenticationException('Silakan login kembali.', [$guardName]);
    }

    public function revoke(User $user, ?string $exceptSessionId = null): void
    {
        Password::deleteToken($user);
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('user_id', $user->getKey())
            ->when($exceptSessionId, fn ($query) => $query->where('id', '!=', $exceptSessionId))
            ->delete();
    }

    public function preserveCurrent(User $user, ?string $guardName = null): void
    {
        $guardName ??= Auth::getDefaultDriver();
        $guard = Auth::guard($guardName);
        $guard->setUser($user);
        session()->regenerate(true);
        session()->put($this->sessionKey($guardName), $guard->hashPasswordForCookie($user->getAuthPassword()));
        Cookie::unqueue($guard->getRecallerName());
        Cookie::queue(Cookie::forget($guard->getRecallerName()));
    }

    private function sessionKey(string $guardName): string
    {
        return 'password_hash_'.$guardName;
    }

    private function clearCurrent(string $guardName): void
    {
        Auth::guard($guardName)->logoutCurrentDevice();
        session()->invalidate();
        session()->regenerateToken();
    }
}
