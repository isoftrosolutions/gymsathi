<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['tenant_id', 'created_by', 'assigned_to', 'subject', 'description', 'status', 'priority', 'internal_notes'])]
class SupportTicket extends Model
{
    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the ticket.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the user who created the ticket.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the admin assigned to the ticket.
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all messages for this ticket.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class)->orderBy('created_at');
    }

    /**
     * Get public messages (visible to gym owner).
     */
    public function publicMessages(): HasMany
    {
        return $this->messages()->where('is_internal', false)->orderBy('created_at');
    }

    /**
     * Get internal messages (admin-only).
     */
    public function internalMessages(): HasMany
    {
        return $this->messages()->where('is_internal', true)->orderBy('created_at');
    }

    /**
     * Check if ticket is open.
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if ticket is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if ticket is resolved.
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    /**
     * Check if ticket is closed.
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Check if ticket is urgent.
     */
    public function isUrgent(): bool
    {
        return $this->priority === 'urgent';
    }

    /**
     * Check if ticket is high priority.
     */
    public function isHighPriority(): bool
    {
        return in_array($this->priority, ['high', 'urgent']);
    }

    /**
     * Mark ticket as in progress.
     */
    public function markInProgress(): void
    {
        $this->update(['status' => 'in_progress']);
    }

    /**
     * Mark ticket as resolved.
     */
    public function markResolved(): void
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }

    /**
     * Mark ticket as closed.
     */
    public function markClosed(): void
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);
    }

    /**
     * Assign ticket to admin.
     */
    public function assignTo(?User $admin): void
    {
        $this->update(['assigned_to' => $admin?->id]);
    }

    /**
     * Update priority.
     */
    public function updatePriority(string $priority): void
    {
        $this->update(['priority' => $priority]);
    }

    /**
     * Add internal note.
     */
    public function addInternalNote(string $note, User $admin): void
    {
        $this->messages()->create([
            'user_id' => $admin->id,
            'message' => $note,
            'is_internal' => true,
            'is_from_admin' => true,
        ]);
    }

    /**
     * Get status badge class for UI.
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'open' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get priority badge class for UI.
     */
    public function getPriorityBadgeClass(): string
    {
        return match ($this->priority) {
            'low' => 'bg-gray-100 text-gray-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get display text for priority.
     */
    public function getPriorityDisplayText(): string
    {
        return match ($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
            default => ucfirst($this->priority),
        };
    }
}
