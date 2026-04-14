<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['support_ticket_id', 'user_id', 'message', 'is_internal', 'is_from_admin', 'attachments'])]
class SupportMessage extends Model
{
    protected $casts = [
        'attachments' => 'array',
        'is_internal' => 'boolean',
        'is_from_admin' => 'boolean',
    ];

    /**
     * Get the ticket this message belongs to.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    /**
     * Get the user who sent this message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if message is visible to gym owner.
     */
    public function isVisibleToGymOwner(): bool
    {
        return ! $this->is_internal;
    }

    /**
     * Check if message is from admin.
     */
    public function isFromAdmin(): bool
    {
        return $this->is_from_admin;
    }

    /**
     * Get formatted timestamp for display.
     */
    public function getFormattedTimestamp(): string
    {
        return $this->created_at->format('M d, Y \a\t H:i');
    }
}
