<?php

namespace App\Http\Middleware;

use App\Services\AccountSessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCurrentAccountSession
{
    public function __construct(private AccountSessionService $sessions) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $this->sessions->ensureCurrent($request->user());
        }

        return $next($request);
    }
}
