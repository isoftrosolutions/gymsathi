<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['created_by', 'title', 'message', 'type', 'channels', 'status', 'scheduled_at', 'recipient_filters'])]
class Announcement extends Model
{
    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'recipient_filters' => 'array',
    ];

    /**
     * Get the admin who created the announcement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if announcement is scheduled.
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if announcement has been sent.
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Check if announcement is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if announcement should be sent via WhatsApp.
     */
    public function sendViaWhatsapp(): bool
    {
        return in_array($this->channels, ['whatsapp', 'both']);
    }

    /**
     * Check if announcement should be sent in-app.
     */
    public function sendInApp(): bool
    {
        return in_array($this->channels, ['in_app', 'both']);
    }

    /**
     * Mark announcement as sent.
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Mark announcement as failed.
     */
    public function markAsFailed(string $reason): void
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason,
        ]);
    }

    /**
     * Schedule announcement for future sending.
     */
    public function schedule($dateTime): void
    {
        $this->update([
            'status' => 'scheduled',
            'scheduled_at' => $dateTime,
        ]);
    }

    /**
     * Get recipients based on filters.
     */
    public function getRecipients()
    {
        $query = Tenant::query();

        // Apply filters if they exist
        if ($this->recipient_filters) {
            if (isset($this->recipient_filters['plan'])) {
                $query->whereHas('plan', function ($q) {
                    $q->where('slug', $this->recipient_filters['plan']);
                });
            }

            if (isset($this->recipient_filters['city'])) {
                $query->where('city', $this->recipient_filters['city']);
            }

            if (isset($this->recipient_filters['status'])) {
                $query->where('status', $this->recipient_filters['status']);
            }
        }

        return $query->where('status', 'active')->get();
    }

    /**
     * Get type badge class for UI.
     */
    public function getTypeBadgeClass(): string
    {
        return match ($this->type) {
            'maintenance' => 'bg-orange-100 text-orange-800',
            'feature' => 'bg-blue-100 text-blue-800',
            'offer' => 'bg-green-100 text-green-800',
            'general' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status badge class for UI.
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'scheduled' => 'bg-blue-100 text-blue-800',
            'sent' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
