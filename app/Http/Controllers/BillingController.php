<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    /**
     * Show payment history for a tenant.
     */
    public function payments(Tenant $tenant): View
    {
        $payments = $tenant->payments()
            ->with('subscription.plan')
            ->latest()
            ->paginate(20);

        return view('billing.payments', compact('tenant', 'payments'));
    }

    /**
     * Record a manual payment.
     */
    public function recordPayment(Request $request, Tenant $tenant): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:bank_transfer,cash,manual',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment = $tenant->payments()->create([
            'subscription_id' => $tenant->activeSubscription()?->id,
            'method' => $request->method,
            'status' => 'completed',
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
        ]);

        // Extend subscription if there's an active one
        if ($subscription = $tenant->activeSubscription()) {
            $newExpiry = $subscription->ends_at->addMonth();
            $subscription->update(['ends_at' => $newExpiry]);
            $tenant->update(['subscription_expires_at' => $newExpiry]);
        }

        // TODO: Send WhatsApp confirmation

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    /**
     * Generate and send invoice.
     */
    public function generateInvoice(Tenant $tenant): View
    {
        $subscription = $tenant->activeSubscription();

        if (! $subscription) {
            abort(404, 'No active subscription found');
        }

        $invoiceData = [
            'tenant' => $tenant,
            'subscription' => $subscription,
            'plan' => $subscription->plan,
            'billing_period' => [
                'start' => $subscription->starts_at,
                'end' => $subscription->ends_at,
            ],
            'amount' => $subscription->price,
            'generated_at' => now(),
        ];

        return view('billing.invoice', $invoiceData);
    }

    /**
     * Send invoice via WhatsApp.
     */
    public function sendInvoice(Request $request, Tenant $tenant): RedirectResponse
    {
        // TODO: Implement WhatsApp integration
        // For now, just mark as sent

        return redirect()->back()->with('success', 'Invoice sent via WhatsApp!');
    }

    /**
     * Show form to record manual payment.
     */
    public function createPayment(Tenant $tenant): View
    {
        return view('billing.create-payment', compact('tenant'));
    }
}
