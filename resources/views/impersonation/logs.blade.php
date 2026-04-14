@extends('layouts.admin')

@section('title', 'Impersonation Logs')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Impersonation Logs</h1>
        <p class="text-gray-600 mt-1">Audit trail of all admin impersonation sessions.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_sessions'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Sessions</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold {{ $stats['active_sessions'] > 0 ? 'text-orange-600' : 'text-gray-900' }}">{{ $stats['active_sessions'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Active Now</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ round($stats['avg_duration'] ?? 0) }}m</p>
            <p class="text-xs text-gray-500 mt-1">Avg Duration</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('admin.impersonation.logs') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Admin</label>
                <select name="admin_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Admins</option>
                    @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Gym</label>
                <select name="tenant_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Gyms</option>
                    @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">Filter</button>
            <a href="{{ route('admin.impersonation.logs') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50">Clear</a>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gym</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Impersonated User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Started</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50 {{ $log->isActive() ? 'bg-orange-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $log->admin?->name ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        @if($log->tenant)
                        <a href="{{ route('admin.tenants.show', $log->tenant) }}" class="text-blue-600 hover:underline">{{ $log->tenant->name }}</a>
                        @else —
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->impersonatedUser?->name ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $log->reason }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ $log->started_at->format('M d, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($log->isActive())
                        <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">Active</span>
                        @else
                        <span class="text-gray-700">{{ $log->getFormattedDuration() }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400">{{ $log->ip_address ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No impersonation sessions found.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection
