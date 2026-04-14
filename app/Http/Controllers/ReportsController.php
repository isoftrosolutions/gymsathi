<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\View\View;

class ReportsController extends Controller
{
    /**
     * Show subscription & billing dashboard.
     */
    public function dashboard(): View
    {
        // MRR calculation
        $mrr = $this->calculateMRR();

        // Plan distribution
        $planDistribution = Plan::withCount(['tenants' => function ($query) {
            $query->whereHas('subscriptions', function ($subQuery) {
                $subQuery->active();
            });
        }])->get();

        // Trial count
        $trialCount = Subscription::onTrial()->count();

        // Recent payments
        $recentPayments = Payment::completed()
            ->with('tenant')
            ->latest()
            ->take(10)
            ->get();

        return view('reports.dashboard', compact(
            'mrr',
            'planDistribution',
            'trialCount',
            'recentPayments'
        ));
    }

    /**
     * Monthly revenue report.
     */
    public function monthlyRevenue(): View
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Payment::completed()
                ->whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->sum('amount');

            $months->push([
                'month' => $date->format('M Y'),
                'revenue' => $revenue,
            ]);
        }

        return view('reports.monthly-revenue', compact('months'));
    }

    /**
     * Revenue by city.
     */
    public function revenueByCity(): View
    {
        $cityRevenue = Tenant::selectRaw('city, SUM(payments.amount) as total_revenue')
            ->join('payments', 'tenants.id', '=', 'payments.tenant_id')
            ->where('payments.status', 'completed')
            ->groupBy('city')
            ->orderByDesc('total_revenue')
            ->get();

        return view('reports.revenue-by-city', compact('cityRevenue'));
    }

    /**
     * Revenue by plan.
     */
    public function revenueByPlan(): View
    {
        $planRevenue = Plan::selectRaw('plans.name, SUM(payments.amount) as total_revenue')
            ->join('subscriptions', 'plans.id', '=', 'subscriptions.plan_id')
            ->join('payments', 'subscriptions.id', '=', 'payments.subscription_id')
            ->where('payments.status', 'completed')
            ->groupBy('plans.id', 'plans.name')
            ->orderByDesc('total_revenue')
            ->get();

        return view('reports.revenue-by-plan', compact('planRevenue'));
    }

    /**
     * Conversion and churn rates.
     */
    public function conversionRates(): View
    {
        // Trial to paid conversion rate
        $totalTrials = Subscription::where('status', '!=', 'trial')->count();
        $convertedTrials = Subscription::where('status', 'active')
            ->whereNotNull('trial_ends_at')
            ->count();

        $conversionRate = $totalTrials > 0 ? ($convertedTrials / $totalTrials) * 100 : 0;

        // Monthly churn rate (last 12 months)
        $churnData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $activeAtStart = Subscription::active()
                ->where('starts_at', '<=', $startOfMonth)
                ->count();

            $cancelledDuringMonth = Subscription::where('status', 'cancelled')
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count();

            $churnRate = $activeAtStart > 0 ? ($cancelledDuringMonth / $activeAtStart) * 100 : 0;

            $churnData->push([
                'month' => $date->format('M Y'),
                'churn_rate' => round($churnRate, 2),
            ]);
        }

        return view('reports.conversion-rates', compact('conversionRate', 'churnData'));
    }

    /**
     * Calculate Monthly Recurring Revenue.
     */
    private function calculateMRR(): float
    {
        return Subscription::active()->sum('price');
    }
}
