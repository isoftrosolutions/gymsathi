<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tenant_id', 'user_id', 'action', 'resource_type', 'resource_id', 'metadata', 'severity', 'message', 'ip_address', 'user_agent'])]
class ActivityLog extends Model
{
    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the tenant this log belongs to.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the user this log is for.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a user action.
     */
    public static function logAction(
        Tenant $tenant,
        ?User $user,
        string $action,
        ?string $resourceType = null,
        $resourceId = null,
        array $metadata = [],
        string $severity = 'info',
        ?string $message = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): self {
        return static::create([
            'tenant_id' => $tenant->id,
            'user_id' => $user?->id,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'metadata' => $metadata,
            'severity' => $severity,
            'message' => $message,
            'ip_address' => $ipAddress ?: request()->ip(),
            'user_agent' => $userAgent ?: request()->userAgent(),
        ]);
    }

    /**
     * Log a sync action.
     */
    public static function logSync(Tenant $tenant, User $user, string $syncType, array $metadata = []): self
    {
        return static::logAction(
            $tenant,
            $user,
            'sync',
            'sync',
            null,
            array_merge($metadata, ['sync_type' => $syncType]),
            'info',
            "Data synchronization: {$syncType}"
        );
    }

    /**
     * Log a login action.
     */
    public static function logLogin(Tenant $tenant, User $user): self
    {
        return static::logAction(
            $tenant,
            $user,
            'login',
            null,
            null,
            [],
            'info',
            'User logged in'
        );
    }

    /**
     * Log an error.
     */
    public static function logError(Tenant $tenant, string $error, array $metadata = [], ?User $user = null): self
    {
        return static::logAction(
            $tenant,
            $user,
            'error',
            null,
            null,
            $metadata,
            'error',
            $error
        );
    }

    /**
     * Check if log is critical.
     */
    public function isCritical(): bool
    {
        return $this->severity === 'critical';
    }

    /**
     * Check if log is error.
     */
    public function isError(): bool
    {
        return in_array($this->severity, ['error', 'critical']);
    }

    /**
     * Get severity badge class for UI.
     */
    public function getSeverityBadgeClass(): string
    {
        return match ($this->severity) {
            'info' => 'bg-blue-100 text-blue-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'error' => 'bg-orange-100 text-orange-800',
            'critical' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get formatted message for display.
     */
    public function getFormattedMessage(): string
    {
        if ($this->message) {
            return $this->message;
        }

        // Generate message from action and resource
        $actionText = match ($this->action) {
            'login' => 'logged in',
            'logout' => 'logged out',
            'sync' => 'synced data',
            'create' => "created {$this->resource_type}",
            'update' => "updated {$this->resource_type}",
            'delete' => "deleted {$this->resource_type}",
            default => $this->action,
        };

        return "User {$actionText}".($this->resource_id ? " (ID: {$this->resource_id})" : '');
    }
}
