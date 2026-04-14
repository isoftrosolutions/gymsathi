@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Platform Activity Logs</h1>
        <p class="text-gray-600 mt-1">All activity across every gym on the platform.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
            <div class="p-2 bg-blue-100 rounded-lg"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
            <div><p class="text-sm text-gray-600">Total Logs</p><p class="text-2xl font-bold">{{ number_format($stats['total_logs']) }}</p></div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
            <div class="p-2 bg-red-100 rounded-lg"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
            <div><p class="text-sm text-gray-600">Errors / Critical</p><p class="text-2xl font-bold text-red-600">{{ number_format($stats['error_logs']) }}</p></div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
            <div class="p-2 bg-orange-100 rounded-lg"><svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg></div>
            <div><p class="text-sm text-gray-600">Gyms with Errors</p><p class="text-2xl font-bold text-orange-600">{{ $stats['gyms_with_errors'] }}</p></div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('admin.activity.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gym</label>
                <select name="tenant_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Gyms</option>
                    @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                <select name="action" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ $action }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Severity</label>
                <select name="severity" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Severities</option>
                    @foreach($severities as $s)
                    <option value="{{ $s }}" {{ request('severity') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Filter</button>
                <a href="{{ route('admin.activity.index') }}" class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50">Clear</a>
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gym</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">{{ $log->created_at->format('M d, H:i') }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $log->tenant?->name ?? '—' }}</td>
                        <td class="px-6 py-3 whitespace-nowrap"><code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $log->action }}</code></td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ $log->user?->name ?? 'System' }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $log->getSeverityBadgeClass() }}">{{ ucfirst($log->severity) }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-500 max-w-xs truncate">{{ $log->getFormattedMessage() }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-right">
                            <a href="{{ route('admin.activity.log', $log) }}" class="text-blue-600 hover:text-blue-900 text-xs">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No activity logs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection
