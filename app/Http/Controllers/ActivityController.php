<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Show activity logs for a specific gym.
     */
    public function show(Tenant $tenant, Request $request): View
    {
        $query = $tenant->activityLogs()->with('user');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->get('action'));
        }

        // Filter by severity
        if ($request->filled('severity')) {
            $query->where('severity', $request->get('severity'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(50);

        // Get unique actions and severities for filter dropdowns
        $actions = $tenant->activityLogs()->distinct()->pluck('action')->sort();
        $severities = ['info', 'warning', 'error', 'critical'];

        // Get activity stats
        $stats = [
            'total_logs' => $tenant->activityLogs()->count(),
            'error_logs' => $tenant->activityLogs()->whereIn('severity', ['error', 'critical'])->count(),
            'sync_logs' => $tenant->activityLogs()->where('action', 'sync')->count(),
            'login_logs' => $tenant->activityLogs()->where('action', 'login')->count(),
        ];

        return view('activity.show', compact('tenant', 'logs', 'stats', 'actions', 'severities'));
    }

    /**
     * Show global activity logs across all gyms.
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::with(['tenant', 'user']);

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->get('action'));
        }

        // Filter by severity
        if ($request->filled('severity')) {
            $query->where('severity', $request->get('severity'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(100);

        // Get data for filter dropdowns
        $tenants = Tenant::active()->select('id', 'name')->get();
        $actions = ActivityLog::distinct()->pluck('action')->sort();
        $severities = ['info', 'warning', 'error', 'critical'];

        // Get global stats
        $stats = [
            'total_logs' => ActivityLog::count(),
            'error_logs' => ActivityLog::whereIn('severity', ['error', 'critical'])->count(),
            'gyms_with_errors' => ActivityLog::whereIn('severity', ['error', 'critical'])
                ->distinct('tenant_id')->count('tenant_id'),
            'most_active_gym' => ActivityLog::selectRaw('tenant_id, COUNT(*) as log_count')
                ->groupBy('tenant_id')
                ->orderByDesc('log_count')
                ->with('tenant')
                ->first(),
        ];

        return view('activity.index', compact('logs', 'stats', 'tenants', 'actions', 'severities'));
    }

    /**
     * Show detailed log entry.
     */
    public function showLog(ActivityLog $log): View
    {
        $log->load(['tenant', 'user']);

        return view('activity.log-detail', compact('log'));
    }

    /**
     * Export activity logs for a gym.
     */
    public function export(Tenant $tenant, Request $request)
    {
        $query = $tenant->activityLogs();

        // Apply same filters as show method
        if ($request->filled('action')) {
            $query->where('action', $request->get('action'));
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->get('severity'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->with('user')->orderBy('created_at', 'desc')->get();

        // Generate CSV content
        $csvContent = "Date,Action,User,Severity,Message,IP Address\n";

        foreach ($logs as $log) {
            $csvContent .= sprintf(
                "%s,%s,%s,%s,%s,%s\n",
                $log->created_at->format('Y-m-d H:i:s'),
                $log->action,
                $log->user?->name ?? 'System',
                $log->severity,
                str_replace(',', ';', $log->getFormattedMessage()),
                $log->ip_address ?? ''
            );
        }

        $filename = "gym-activity-{$tenant->slug}-".now()->format('Y-m-d').'.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
