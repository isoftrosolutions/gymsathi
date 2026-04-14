<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Use DB to avoid triggering the User model's Global Scopes (recursion)
            $userData = \Illuminate\Support\Facades\DB::table('users')
                ->where('id', auth()->id())
                ->first(['tenant_id', 'platform_role']);

            if ($userData) {
                config([
                    'app.tenant_id' => $userData->tenant_id,
                    'app.platform_role' => $userData->platform_role,
                ]);
            }
        }

        return $next($request);
    }
}
