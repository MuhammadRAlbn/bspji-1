<?php

namespace App\Http\Middleware;

use App\Filament\Clusters\ZonaIntegritas\Resources\ZonaIntegritasPengaduanResource;
use App\Models\User;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $authenticatedUser = $request->user();
        if (! $authenticatedUser) {
            return $next($request);
        }

        $user = $authenticatedUser->fresh();
        if (! $user?->canAccessPanel(Filament::getCurrentOrDefaultPanel())) {
            Filament::auth()->logoutCurrentDevice();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            abort(403);
        }

        Filament::auth()->setUser($user);

        if ($user->isPengaduanStaff()) {
            if ($request->routeIs('filament.admin.pages.dashboard')) {
                return redirect()->to(ZonaIntegritasPengaduanResource::getUrl('index'));
            }

            $allowed = $request->routeIs(
                'filament.admin.zona-integritas.resources.zona-integritas-pengaduans.*',
                'filament.admin.zona-integritas',
                'filament.admin.auth.logout',
                'filament.admin.auth.profile',
            ) || ($user->role === User::ROLE_KEPALA_BALAI && $request->routeIs('filament.admin.zona-integritas.resources.riwayat-penghapusan-pengaduans.*'));
            abort_unless($allowed, 403);

            if ($user->role === User::ROLE_KEPALA_BALAI) {
                abort_if($request->routeIs('filament.admin.zona-integritas.resources.zona-integritas-pengaduans.edit'), 403);
            }
        }

        return $next($request);
    }
}
