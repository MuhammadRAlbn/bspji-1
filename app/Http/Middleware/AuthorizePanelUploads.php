<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizePanelUploads
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user()?->fresh();
        abort_unless($user?->hasPanelAccess() && in_array($user->role, [User::ROLE_ADMIN, User::ROLE_HUMAS, User::ROLE_FAP], true), 403);

        return $next($request);
    }
}
