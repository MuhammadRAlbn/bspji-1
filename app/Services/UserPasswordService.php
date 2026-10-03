<?php

namespace App\Services;

use App\Exceptions\PasswordChangeThrottled;
use App\Models\User;
use App\Rules\PasswordWithinHashLimit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserPasswordService
{
    public function __construct(private AccountSessionService $sessions) {}

    public function change(User $actor, array $data, string $ip): User
    {
        $this->limitAttempts($actor, $ip);
        $user = DB::transaction(function () use ($actor, $data): User {
            $user = User::query()->whereKey($actor->getKey())->lockForUpdate()->first();
            abort_unless($user?->hasPanelAccess(), 403);
            $this->sessions->assertCredentials($user);

            $validated = Validator::make($data, [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:12', 'confirmed', new PasswordWithinHashLimit],
                'password_confirmation' => ['required', 'string'],
            ])->validate();

            if (! Hash::check($validated['current_password'], $user->password)) {
                throw ValidationException::withMessages(['current_password' => 'Password saat ini tidak cocok.']);
            }
            if (Hash::check($validated['password'], $user->password)) {
                throw ValidationException::withMessages(['password' => 'Password baru harus berbeda dari password saat ini.']);
            }

            $user->forceFill(['password' => Hash::make($validated['password']), 'remember_token' => Str::random(60)])->save();
            $this->sessions->revoke($user, session()->getId());

            return $user;
        });

        $this->sessions->preserveCurrent($user);

        return $user;
    }

    private function limitAttempts(User $user, string $ip): void
    {
        $limits = ['change-password:account:'.$user->getKey() => 5, 'change-password:ip:'.hash('sha256', $ip) => 20];
        $wait = 0;
        foreach ($limits as $key => $limit) {
            if (RateLimiter::tooManyAttempts($key, $limit)) {
                $wait = max($wait, RateLimiter::availableIn($key));
            }
        }
        if ($wait > 0) {
            throw new PasswordChangeThrottled($wait);
        }
        foreach ($limits as $key => $limit) {
            if (RateLimiter::hit($key, 60) > $limit) {
                $wait = max(1, $wait, RateLimiter::availableIn($key));
            }
        }
        if ($wait > 0) {
            throw new PasswordChangeThrottled($wait);
        }
    }
}
