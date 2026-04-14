@extends('layouts.admin')

@section('title', 'Log Entry #' . $log->id)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-6">
        <a href="{{ $log->tenant ? route('admin.activity.show', $log->tenant) : route('admin.activity.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700">← Back to Logs</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-1">Log Entry <span class="text-gray-400">#{{ $log->id }}</span></h1>
    </div>

    <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
        <div class="px-6 py-4 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">Action</p>
                <code class="text-sm bg-gray-100 px-2 py-1 rounded mt-1 inline-block">{{ $log->action }}</code>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">Severity</p>
                <span class="mt-1 inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $log->getSeverityBadgeClass() }}">{{ ucfirst($log->severity) }}</span>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">Gym</p>
                @if($log->tenant)
                <a href="{{ route('admin.activity.show', $log->tenant) }}" class="text-sm text-blue-600 hover:underline mt-1 block">{{ $log->tenant->name }}</a>
                @else
                <p class="text-sm text-gray-500 mt-1">—</p>
                @endif
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">User</p>
                <p class="text-sm text-gray-900 mt-1">{{ $log->user?->name ?? 'System' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">Time</p>
                <p class="text-sm text-gray-900 mt-1">{{ $log->created_at->format('M d, Y H:i:s') }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">IP Address</p>
                <p class="text-sm text-gray-900 mt-1">{{ $log->ip_address ?? '—' }}</p>
            </div>
            @if($log->resource_type)
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase">Resource</p>
                <p class="text-sm text-gray-900 mt-1">{{ $log->resource_type }} #{{ $log->resource_id }}</p>
            </div>
            @endif
        </div>

        @if($log->message)
        <div class="px-6 py-4">
            <p class="text-xs font-medium text-gray-500 uppercase mb-2">Message</p>
            <p class="text-sm text-gray-800 bg-gray-50 p-3 rounded">{{ $log->message }}</p>
        </div>
        @endif

        @if($log->metadata)
        <div class="px-6 py-4">
            <p class="text-xs font-medium text-gray-500 uppercase mb-2">Metadata</p>
            <pre class="text-xs bg-gray-50 border border-gray-200 rounded p-4 overflow-x-auto">{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($log->user_agent)
        <div class="px-6 py-4">
            <p class="text-xs font-medium text-gray-500 uppercase mb-2">User Agent</p>
            <p class="text-xs text-gray-500 break-all">{{ $log->user_agent }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
