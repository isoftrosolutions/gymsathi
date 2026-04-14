<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tenant_id', 'subscription_id', 'reference_id', 'method', 'status', 'amount', 'fee', 'currency', 'payment_date', 'notes', 'metadata'])]
class Payment extends Model
{
    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'payment_date' => 'date',
        'metadata' => 'array',
    ];

    /**
     * Get the tenant that made the payment.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the subscription this payment is for.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Check if payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Scope for completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for payments by method.
     */
    public function scopeByMethod($query, string $method)
    {
        return $query->where('method', $method);
    }

    /**
     * Scope for payments in date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }
}
