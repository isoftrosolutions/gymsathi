@extends('layouts.admin')

@section('title', 'Activity — ' . $tenant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-start">
        <div>
            <a href="{{ route('admin.activity.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← All Activity</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $tenant->name }}</h1>
            <p class="text-gray-600">Activity log · {{ $tenant->city }}</p>
        </div>
        <a href="{{ route('admin.activity.export', $tenant) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Export CSV
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_logs']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Logs</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-red-600">{{ number_format($stats['error_logs']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Errors</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['sync_logs']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Syncs</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['login_logs']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Logins</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('admin.activity.show', $tenant) }}" method="GET" class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Action</label>
                <select name="action" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ $action }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Severity</label>
                <select name="severity" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All</option>
                    @foreach($severities as $s)
                    <option value="{{ $s }}" {{ request('severity') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm">Filter</button>
                <a href="{{ route('admin.activity.show', $tenant) }}" class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50">Clear</a>
            </div>
        </form>
    </div>

    <!-- Logs -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 {{ $log->isError() ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">{{ $log->created_at->format('M d, H:i:s') }}</td>
                        <td class="px-6 py-3 whitespace-nowrap"><code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $log->action }}</code></td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ $log->user?->name ?? 'System' }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $log->getSeverityBadgeClass() }}">{{ ucfirst($log->severity) }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700 max-w-sm truncate">{{ $log->getFormattedMessage() }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-400">{{ $log->ip_address ?? '—' }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-right">
                            <a href="{{ route('admin.activity.log', $log) }}" class="text-blue-600 hover:text-blue-900 text-xs">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No logs found.</td></tr>
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
