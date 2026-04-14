<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display subscription details for a tenant.
     */
    public function show(Tenant $tenant): View
    {
        $subscription = $tenant->activeSubscription();
        $payments = $tenant->payments()->latest()->take(10)->get();
        $plans = Plan::active()->get();

        return view('subscriptions.show', compact('tenant', 'subscription', 'payments', 'plans'));
    }

    /**
     * Change a tenant's subscription plan.
     */
    public function changePlan(Request $request, Tenant $tenant): RedirectResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $newPlan = Plan::findOrFail($request->plan_id);

        $tenant->changePlan($newPlan);

        // TODO: Send WhatsApp confirmation
        // TODO: Calculate and handle proration

        return redirect()->back()->with('success', "Plan changed to {$newPlan->name} successfully!");
    }

    /**
     * Extend trial period for a tenant.
     */
    public function extendTrial(Request $request, Tenant $tenant): RedirectResponse
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $tenant->extendTrial($request->days);

        // TODO: Send WhatsApp notification

        return redirect()->back()->with('success', "Trial extended by {$request->days} days!");
    }

    /**
     * Cancel a subscription.
     */
    public function cancel(Tenant $tenant): RedirectResponse
    {
        $subscription = $tenant->activeSubscription();

        if ($subscription) {
            $subscription->cancel();
        }

        return redirect()->back()->with('success', 'Subscription cancelled successfully!');
    }

    /**
     * Reactivate a cancelled subscription.
     */
    public function reactivate(Tenant $tenant): RedirectResponse
    {
        $subscription = $tenant->subscriptions()
            ->where('status', 'cancelled')
            ->latest()
            ->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'active',
                'auto_renew' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Subscription reactivated successfully!');
    }

    /**
     * Toggle auto-renew for subscription.
     */
    public function toggleAutoRenew(Tenant $tenant): RedirectResponse
    {
        $subscription = $tenant->activeSubscription();

        if (! $subscription) {
            return redirect()->back()->with('error', 'No active subscription found.');
        }

        $subscription->update(['auto_renew' => ! $subscription->auto_renew]);
        $status = $subscription->auto_renew ? 'enabled' : 'disabled';

        return redirect()->back()->with('success', "Auto-renew {$status}!");
    }
}
