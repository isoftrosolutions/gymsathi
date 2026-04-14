<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['admin_user_id', 'impersonated_tenant_id', 'impersonated_user_id', 'reason', 'started_at', 'session_data', 'ip_address', 'user_agent'])]
class ImpersonationLog extends Model
{
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'session_data' => 'array',
    ];

    /**
     * Get the admin who performed the impersonation.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Get the tenant being impersonated.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'impersonated_tenant_id');
    }

    /**
     * Get the user being impersonated.
     */
    public function impersonatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'impersonated_user_id');
    }

    /**
     * Check if impersonation is still active.
     */
    public function isActive(): bool
    {
        return $this->ended_at === null;
    }

    /**
     * End the impersonation session.
     */
    public function endSession(): void
    {
        $this->update(['ended_at' => now()]);
    }

    /**
     * Get session duration in minutes.
     */
    public function getDurationInMinutes(): ?float
    {
        if (! $this->ended_at) {
            return null;
        }

        return $this->started_at->diffInMinutes($this->ended_at);
    }

    /**
     * Get formatted session duration.
     */
    public function getFormattedDuration(): string
    {
        if (! $this->ended_at) {
            return 'Active';
        }

        $minutes = $this->getDurationInMinutes();
        if ($minutes < 60) {
            return "{$minutes}m";
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return "{$hours}h {$remainingMinutes}m";
    }

    /**
     * Create a new impersonation log entry.
     */
    public static function startImpersonation(User $admin, Tenant $tenant, User $impersonatedUser, string $reason): self
    {
        return static::create([
            'admin_user_id' => $admin->id,
            'impersonated_tenant_id' => $tenant->id,
            'impersonated_user_id' => $impersonatedUser->id,
            'reason' => $reason,
            'started_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_data' => [
                'original_admin_id' => session('impersonate.original_admin_id') ?? $admin->id,
                'original_tenant_id' => session('impersonate.original_tenant_id') ?? $tenant->id,
            ],
        ]);
    }
}
