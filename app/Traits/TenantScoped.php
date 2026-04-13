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
            if (auth()->check() && auth()->user()->platform_role !== 'super_admin') {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });
    }
}
