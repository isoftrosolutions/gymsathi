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
            if (auth()->check()) {
                $user = auth()->user();
                
                // If it's a super admin, don't scope
                if ($user->platform_role === 'super_admin') {
                    return;
                }

                // Apply tenant scope
                $builder->where($builder->getQuery()->from . '.tenant_id', $user->tenant_id);
            }
        });
    }
}
