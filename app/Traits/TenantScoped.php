<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait TenantScoped
{
    /**
     * Boot the trait.
     */
    protected static function bootTenantScoped(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->tenant_id) && auth()->check()) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            $platformRole = config('app.platform_role');
            $tenantId = config('app.tenant_id');

            // If it's a super admin, don't scope
            if ($platformRole === 'super_admin') {
                return;
            }

            // If we have a tenant ID from the middleware, apply scope
            if ($tenantId !== null) {
                $builder->where($builder->getQuery()->from.'.tenant_id', $tenantId);
            }
        });
    }
}
