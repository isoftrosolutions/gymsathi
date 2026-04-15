@extends('layouts.admin')

@section('title', 'Support Dashboard')

@section('content')
<div class="min-h-screen bg-dark-surface text-on-surface font-body">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-12">
            <h1 class="text-4xl font-headline font-bold text-on-surface">Support Dashboard</h1>
            <p class="text-on-surface-variant mt-3 font-medium">Manage gym support tickets and communications</p>
        </div>

        <!-- Support Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-500/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Total Tickets</p>
                        <p class="text-3xl font-headline font-bold text-blue-400">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-500/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Open Tickets</p>
                        <p class="text-3xl font-headline font-bold text-yellow-400">{{ $stats['open'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-red-500/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Urgent Tickets</p>
                        <p class="text-3xl font-headline font-bold text-red-400">{{ $stats['urgent'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-lime/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Unassigned</p>
                        <p class="text-3xl font-headline font-bold text-primary-lime">{{ $stats['unassigned'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-surface-low rounded-2xl shadow-xl p-8 mb-12 border border-outline">
            <form action="{{ route('admin.support.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide mb-3">Search</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by subject or gym name..."
                               class="w-full bg-surface-low border border-outline rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary-lime focus:border-primary-lime transition-all pl-12">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-on-surface-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide mb-3">Status</label>
                    <select name="status" class="w-full bg-surface-low border border-outline rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary-lime focus:border-primary-lime transition-all">
                        <option value="">All Statuses</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide mb-3">Priority</label>
                    <select name="priority" class="w-full bg-surface-low border border-outline rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary-lime focus:border-primary-lime transition-all">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-primary-lime hover:bg-primary-lime/90 text-dark-surface px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide transition-all">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tickets Table -->
        <div class="bg-surface-low rounded-2xl shadow-xl overflow-hidden border border-outline">
            <div class="px-8 py-6 border-b border-outline">
                <h2 class="text-2xl font-headline font-bold text-on-surface">Support Tickets</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-outline bg-surface">
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Ticket</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Gym</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Created</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-surface transition-all">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-base font-bold text-on-surface">{{ $ticket->subject }}</div>
                                    <div class="text-sm text-on-surface-variant mt-1">{{ Str::limit($ticket->description, 50) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-base font-bold text-on-surface">{{ $ticket->tenant->name }}</div>
                                <div class="text-sm text-on-surface-variant">{{ $ticket->tenant->city }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                    @if($ticket->status === 'open') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                    @elseif($ticket->status === 'in_progress') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                    @elseif($ticket->status === 'resolved') bg-green-500/20 text-green-400 border border-green-500/30
                                    @else bg-gray-500/20 text-gray-400 border border-gray-500/30 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                    @if($ticket->priority === 'urgent') bg-red-500/20 text-red-400 border border-red-500/30
                                    @elseif($ticket->priority === 'high') bg-orange-500/20 text-orange-400 border border-orange-500/30
                                    @elseif($ticket->priority === 'medium') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                    @else bg-green-500/20 text-green-400 border border-green-500/30 @endif">
                                    {{ $ticket->getPriorityDisplayText() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-on-surface-variant">
                                {{ $ticket->assignedAdmin?->name ?? 'Unassigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-on-surface-variant">
                                {{ $ticket->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.support.show', $ticket) }}" class="text-primary-lime hover:text-primary-lime/80 font-bold uppercase tracking-wide transition-all">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <div class="mb-4">
                                    <svg class="w-12 h-12 text-on-surface-variant mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-on-surface-variant text-lg font-medium mb-2">No support tickets found</p>
                                    <p class="text-on-surface-variant/70 text-sm">All tickets are resolved or there are no active issues</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
            <div class="px-8 py-6 border-t border-outline">
                {{ $tickets->links() }}
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <a href="{{ route('admin.announcements.index') }}" class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline hover:bg-surface hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="p-4 bg-green-500/20 rounded-xl mr-6 group-hover:bg-green-500/30 transition-all">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-1">Broadcast Announcements</h3>
                        <p class="text-on-surface-variant text-sm font-medium">Send messages to all gyms</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.activity.index') }}" class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline hover:bg-surface hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="p-4 bg-primary-lime/20 rounded-xl mr-6 group-hover:bg-primary-lime/30 transition-all">
                        <svg class="w-8 h-8 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-1">Activity Logs</h3>
                        <p class="text-on-surface-variant text-sm font-medium">Monitor gym activity</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.impersonation.logs') }}" class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline hover:bg-surface hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="p-4 bg-orange-500/20 rounded-xl mr-6 group-hover:bg-orange-500/30 transition-all">
                        <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-1">Impersonation Logs</h3>
                        <p class="text-on-surface-variant text-sm font-medium">View admin access history</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection