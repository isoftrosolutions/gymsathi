<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['tenant_id', 'plan_id', 'status', 'price', 'starts_at', 'ends_at', 'trial_ends_at', 'auto_renew', 'metadata'])]
class Subscription extends Model
{
    protected $casts = [
        'price' => 'decimal:2',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'trial_ends_at' => 'date',
        'auto_renew' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the tenant that owns the subscription.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the plan for this subscription.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get payments for this subscription.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if subscription is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at?->isFuture() === true;
    }

    /**
     * Check if subscription is in trial period.
     */
    public function onTrial(): bool
    {
        return $this->status === 'trial' &&
               $this->trial_ends_at &&
               $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired(): bool
    {
        return $this->ends_at !== null && $this->ends_at->isPast() && $this->status !== 'cancelled';
    }

    /**
     * Check if subscription is past due.
     */
    public function isPastDue(): bool
    {
        return $this->status === 'past_due';
    }

    /**
     * Extend trial by specified days.
     */
    public function extendTrial(int $days): void
    {
        $this->trial_ends_at = ($this->trial_ends_at ?? now())->addDays($days);
        $this->save();
    }

    /**
     * Cancel the subscription.
     */
    public function cancel(): void
    {
        $this->status = 'cancelled';
        $this->auto_renew = false;
        $this->save();
    }

    /**
     * Scope for active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('ends_at', '>', now());
    }

    /**
     * Scope for expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('ends_at', '<=', now())
            ->where('status', '!=', 'cancelled');
    }

    /**
     * Scope for trial subscriptions.
     */
    public function scopeOnTrial($query)
    {
        return $query->where('status', 'trial')
            ->where('trial_ends_at', '>', now());
    }
}
