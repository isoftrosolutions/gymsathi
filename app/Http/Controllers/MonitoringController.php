<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tenant;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    /**
     * Display the system monitoring dashboard.
     */
    public function index(): View
    {
        $tenants = Tenant::all();
        $pendingCount = Tenant::where('pending_sync_count', '>', 0)->count();
        
        return view('admin.monitoring.index', compact('tenants', 'pendingCount'));
    }

    /**
     * Display the offline sync health view.
     */
    public function sync(): View
    {
        $tenants = Tenant::orderBy('pending_sync_count', 'desc')->get();
        $totalPending = Tenant::sum('pending_sync_count');
        $criticalCount = Tenant::where('pending_sync_count', '>', 20)->count();

        return view('admin.monitoring.sync', compact('tenants', 'totalPending', 'criticalCount'));
    }
}
