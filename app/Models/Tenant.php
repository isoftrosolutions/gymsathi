<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'status',
    'plan_id',
    'city',
    'address',
    'owner_name',
    'owner_phone',
    'subscription_expires_at',
    'suspended_at',
    'approved_at',
    'rejected_at',
    'settings',
    'last_sync_at',
    'pending_sync_count',
])]
class Tenant extends Model
{
    /** @var list<string> */
    protected $casts = [
        'settings' => 'array',
        'subscription_expires_at' => 'datetime',
        'suspended_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    /**
     * Get the users for the tenant.
     *
     * @return HasMany<User, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the current plan for the tenant.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get all subscriptions for the tenant.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the active subscription.
     */
    public function activeSubscription()
    {
        return $this->subscriptions()->active()->first();
    }

    /**
     * Get all payments for the tenant.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get all gym packages for the tenant.
     */
    public function gymPackages(): HasMany
    {
        return $this->hasMany(GymPackage::class);
    }

    /**
     * Get all member packages for the tenant.
     */
    public function memberPackages(): HasMany
    {
        return $this->hasMany(MemberPackage::class);
    }

    /**
     * Check if tenant has an active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Check if tenant is on trial.
     */
    public function onTrial(): bool
    {
        $subscription = $this->subscriptions()->onTrial()->first();

        return $subscription !== null;
    }

    /**
     * Check if tenant's subscription is expired.
     */
    public function isExpired(): bool
    {
        return $this->subscription_expires_at && $this->subscription_expires_at->isPast();
    }

    /**
     * Get subscription status.
     */
    public function getSubscriptionStatus(): string
    {
        if ($this->onTrial()) {
            return 'trial';
        }

        if ($this->hasActiveSubscription()) {
            return 'active';
        }

        if ($this->isExpired()) {
            return 'expired';
        }

        return 'inactive';
    }

    /**
     * Subscribe to a plan.
     */
    public function subscribeTo(Plan $plan, $trialDays = null): Subscription
    {
        // End any existing active subscription
        if ($activeSubscription = $this->activeSubscription()) {
            $activeSubscription->cancel();
        }

        $trialEndsAt = $trialDays ? now()->addDays($trialDays) : null;
        $startsAt = now();
        $endsAt = $trialEndsAt ? $trialEndsAt : now()->addMonth();

        $subscription = $this->subscriptions()->create([
            'plan_id' => $plan->id,
            'status' => $trialEndsAt ? 'trial' : 'active',
            'price' => $plan->price,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'trial_ends_at' => $trialEndsAt,
        ]);

        // Update tenant's plan reference
        $this->update([
            'plan_id' => $plan->id,
            'subscription_expires_at' => $endsAt,
        ]);

        return $subscription;
    }

    /**
     * Change subscription plan.
     */
    public function changePlan(Plan $newPlan): Subscription
    {
        $currentSubscription = $this->activeSubscription();

        if (! $currentSubscription) {
            return $this->subscribeTo($newPlan);
        }

        // Calculate prorated amount if needed
        // For now, just change the plan immediately

        $currentSubscription->update([
            'plan_id' => $newPlan->id,
            'price' => $newPlan->price,
        ]);

        $this->update(['plan_id' => $newPlan->id]);

        return $currentSubscription;
    }

    /**
     * Extend trial period.
     */
    public function extendTrial(int $days): void
    {
        $subscription = $this->subscriptions()->onTrial()->first();

        if ($subscription) {
            $subscription->extendTrial($days);
            $this->update(['subscription_expires_at' => $subscription->trial_ends_at]);
        }
    }

    /**
     * Status management methods
     */

    /**
     * Check if gym is pending approval.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if gym is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if gym is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if gym is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Scope for active tenants.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Approve a pending gym.
     */
    public function approve(): void
    {
        if ($this->isPending()) {
            $this->update([
                'status' => 'active',
                'approved_at' => now(),
            ]);
        }
    }

    /**
     * Reject a pending gym.
     */
    public function reject(): void
    {
        if ($this->isPending()) {
            $this->update([
                'status' => 'rejected',
                'rejected_at' => now(),
            ]);
        }
    }

    /**
     * Suspend an active gym.
     */
    public function suspend(): void
    {
        if ($this->isActive() || $this->isExpired()) {
            $this->update([
                'status' => 'suspended',
                'suspended_at' => now(),
            ]);
        }
    }

    /**
     * Reactivate a suspended gym.
     */
    public function reactivate(): void
    {
        if ($this->isSuspended()) {
            $this->update([
                'status' => 'active',
                'suspended_at' => null,
            ]);
        }
    }

    /**
     * Mark gym as expired.
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * Transfer ownership to a new owner.
     */
    public function transferOwnership(string $newOwnerName, string $newOwnerPhone): void
    {
        $this->update([
            'owner_name' => $newOwnerName,
            'owner_phone' => $newOwnerPhone,
        ]);

        // Update the admin user's details if they exist
        $adminUser = $this->users()->whereHas('role', function ($q) {
            $q->where('slug', 'admin');
        })->first();

        if ($adminUser) {
            $adminUser->update([
                'name' => $newOwnerName,
                'email' => $newOwnerPhone.'@gymsathi.com',
            ]);
        }
    }

    /**
     * Get member count (placeholder - would need Members model).
     */
    public function getMemberCount(): int
    {
        // TODO: Implement when Members model exists
        return 0;
    }

    /**
     * Get status badge color for UI.
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'suspended' => 'bg-red-100 text-red-800',
            'expired' => 'bg-orange-100 text-orange-800',
            'rejected' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status display text.
     */
    public function getStatusDisplayText(): string
    {
        return match ($this->status) {
            'active' => 'Active',
            'pending' => 'Pending Approval',
            'suspended' => 'Suspended',
            'expired' => 'Expired',
            'rejected' => 'Rejected',
            default => ucfirst($this->status),
        };
    }

    /**
     * Support & Communication Relationships
     */

    /**
     * Get all support tickets for this tenant.
     */
    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * Get open support tickets.
     */
    public function openSupportTickets(): HasMany
    {
        return $this->supportTickets()->whereIn('status', ['open', 'in_progress']);
    }

    /**
     * Get all activity logs for this tenant.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get recent activity logs.
     */
    public function recentActivityLogs(int $limit = 10): HasMany
    {
        return $this->activityLogs()->latest()->limit($limit);
    }

    /**
     * Log an activity for this tenant.
     */
    public function logActivity(string $action, ?User $user = null, array $metadata = [], string $severity = 'info', ?string $message = null): ActivityLog
    {
        return ActivityLog::logAction(
            $this,
            $user,
            $action,
            null,
            null,
            $metadata,
            $severity,
            $message
        );
    }

    /**
     * Get support tickets count.
     */
    public function getSupportTicketsCount(): int
    {
        return $this->supportTickets()->count();
    }

    /**
     * Get open support tickets count.
     */
    public function getOpenSupportTicketsCount(): int
    {
        return $this->openSupportTickets()->count();
    }
}
