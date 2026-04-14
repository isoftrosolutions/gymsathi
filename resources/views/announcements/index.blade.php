@extends('layouts.admin')

@section('title', 'Announcements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Announcements</h1>
            <p class="text-gray-600 mt-1">Broadcast messages to gyms via WhatsApp or in-app.</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            + New Announcement
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $stats['sent'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Sent</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $stats['scheduled'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Scheduled</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-gray-500">{{ $stats['draft'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Draft</p>
        </div>
    </div>

    @if(session('success'))
    <div id="toast" class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm flex justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="font-bold">×</button>
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('admin.announcements.index') }}" method="GET" class="flex gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Type</label>
                <select name="type" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All</option>
                    <option value="maintenance" {{ request('type') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="feature" {{ request('type') === 'feature' ? 'selected' : '' }}>Feature</option>
                    <option value="offer" {{ request('type') === 'offer' ? 'selected' : '' }}>Offer</option>
                    <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">Filter</button>
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50">Clear</a>
        </form>
    </div>

    <!-- List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Channel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipients</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($announcements as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="text-sm font-medium text-gray-900">{{ $a->title }}</p>
                        <p class="text-xs text-gray-500">{{ Str::limit($a->message, 60) }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $a->getTypeBadgeClass() }}">{{ ucfirst($a->type) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $a->channels)) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $a->getStatusBadgeClass() }}">{{ ucfirst($a->status) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $a->recipients_count ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ $a->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                        <a href="{{ route('admin.announcements.show', $a) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        @if(!$a->isSent())
                        <a href="{{ route('admin.announcements.edit', $a) }}" class="text-gray-600 hover:text-gray-900">Edit</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No announcements yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($announcements->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $announcements->links() }}</div>
        @endif
    </div>
</div>
@endsection
