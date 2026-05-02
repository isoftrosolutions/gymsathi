<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $userData = DB::table('users')
                ->where('id', auth()->id())
                ->first(['tenant_id', 'platform_role']);

            if ($userData) {
                $tenant = Tenant::find($userData->tenant_id);

                config([
                    'app.tenant_id' => $userData->tenant_id,
                    'app.platform_role' => $userData->platform_role,
                ]);

                if ($tenant) {
                    view()->share('tenant', $tenant);
                    config(['app.name' => $tenant->name]);
                }
            }
        }

        return $next($request);
    }
}
