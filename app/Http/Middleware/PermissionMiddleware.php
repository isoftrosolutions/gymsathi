<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! auth()->check() || ! auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized access - Missing permission: '.$permission);
        }

        return $next($request);
    }
}
