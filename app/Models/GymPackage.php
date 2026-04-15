<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GymPackage extends Model
{
    use TenantScoped;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'price',
        'duration_days',
        'duration_type',
        'is_active',
        'is_featured',
        'max_members',
        'features',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'features' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function memberPackages(): HasMany
    {
        return $this->hasMany(MemberPackage::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rs. '.number_format($this->price, 0);
    }

    public function getDurationTextAttribute(): string
    {
        $days = $this->duration_days;
        if ($this->duration_type === 'months') {
            return $days.' month'.($days > 1 ? 's' : '');
        } elseif ($this->duration_type === 'years') {
            return $days.' year'.($days > 1 ? 's' : '');
        }

        return $days.' day'.($days > 1 ? 's' : '');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
