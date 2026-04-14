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
            $tenantId = auth()->user()->tenant_id;

            // Share the tenant ID globally for the current request
            config(['app.tenant_id' => $tenantId]);

            // You can also share the Tenant object itself
            // if ($tenantId) {
            //     app()->instance(Tenant::class, Tenant::find($tenantId));
            // }
        }

        return $next($request);
    }
}
