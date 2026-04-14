<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'price', 'max_members', 'features', 'is_active', 'trial_days'])]
class Plan extends Model
{
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the tenants subscribed to this plan.
     */
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Get active plans only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if plan allows unlimited members.
     */
    public function hasUnlimitedMembers(): bool
    {
        return is_null($this->max_members);
    }
}
