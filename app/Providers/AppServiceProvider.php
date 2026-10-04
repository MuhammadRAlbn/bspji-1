<?php

namespace App\Providers;

use App\Http\Middleware\AuthorizePanelUploads;
use App\Http\Middleware\EnsureCurrentAccountSession;
use App\Http\Responses\AdminLoginResponse;
use App\Models\News;
use App\Models\NewsComment;
use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;
use App\Observers\NewsObserver;
use App\Services\AccountSessionService;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Support\Facades\FilamentTimezone;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginResponse::class, AdminLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentTimezone::set('Asia/Jakarta');

        News::observe(NewsObserver::class);

        Event::listen(Login::class, fn (Login $event) => app(AccountSessionService::class)->initializeFromLogin($event));

        $uploadMiddleware = config('livewire.temporary_file_upload.middleware') ?: ['throttle:60,1'];
        config(['livewire.temporary_file_upload.middleware' => [...(array) $uploadMiddleware, EnsureCurrentAccountSession::class, AuthorizePanelUploads::class]]);

        Gate::before(function (User $user, string $ability, array $arguments): bool|Response|null {
            if (! $user->hasPanelAccess()) {
                return false;
            }

            $model = $this->resolveGateModel($arguments[0] ?? null);

            if ($model === null) {
                return null;
            }

            if ($user->isPengaduanStaff()) {
                $abilities = ['viewAny', 'view', 'update', 'delete', 'deleteAny'];
                if ($user->role === User::ROLE_KEPALA_BALAI) {
                    $abilities = [...$abilities, 'viewHistoryAny', 'viewHistory'];
                }

                return $model === ZonaIntegritasPengaduan::class && in_array($ability, $abilities, true) ? null : false;
            }

            if (! $user->isHumas()) {
                return null;
            }

            return $user->canManageNewsContent() && in_array($model, [
                News::class,
                NewsComment::class,
            ], true);
        });

        RateLimiter::for('news-comments', function (Request $request) {
            return Limit::perMinute(10, 10)->by($request->ip() ?? 'unknown');
        });

        RateLimiter::for('zona-integritas-pengaduan', function (Request $request) {
            return Limit::perMinute(5, 10)->by($request->ip() ?? 'unknown');
        });
    }

    private function resolveGateModel(mixed $argument): ?string
    {
        if ($argument instanceof Model) {
            return $argument::class;
        }

        if (is_string($argument) && is_a($argument, Model::class, true)) {
            return $argument;
        }

        return null;
    }
}
