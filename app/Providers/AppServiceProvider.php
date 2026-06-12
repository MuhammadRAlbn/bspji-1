<?php

namespace App\Providers;

use App\Models\News;
use App\Models\NewsComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, string $ability, array $arguments): bool|Response|null {
            if (! $user->isHumas()) {
                return null;
            }

            $model = $this->resolveGateModel($arguments[0] ?? null);

            if ($model === null) {
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
