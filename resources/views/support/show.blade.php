@extends('layouts.admin')

@section('title', 'Support Ticket - ' . $ticket->subject)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $ticket->subject }}</h1>
                <div class="flex items-center gap-4 mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider {{ $ticket->getStatusBadgeClass() }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider {{ $ticket->getPriorityBadgeClass() }}">
                        {{ $ticket->getPriorityDisplayText() }}
                    </span>
                    <span class="text-gray-600">From {{ $ticket->tenant->name }}</span>
                </div>
            </div>
            <a href="{{ route('admin.support.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                ← Back to Tickets
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Ticket Details & Messages -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Ticket Details</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gym</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $ticket->tenant->name }}</p>
                        <p class="text-sm text-gray-500">{{ $ticket->tenant->city }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created By</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $ticket->creator->name }}</p>
                        <p class="text-sm text-gray-500">{{ $ticket->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Assigned To</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $ticket->assignedAdmin?->name ?? 'Unassigned' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $ticket->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                @if($ticket->internal_notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Internal Notes</h3>
                    <p class="text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $ticket->internal_notes }}</p>
                </div>
                @endif
            </div>

            <!-- Original Description -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Original Issue</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $ticket->description }}</p>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                        <span class="text-sm text-gray-500">{{ $ticket->creator->name }}</span>
                        <span class="text-sm text-gray-500">{{ $ticket->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Conversation</h3>
                <div class="space-y-4">
                    @foreach($ticket->messages as $message)
                    <div class="flex {{ $message->isFromAdmin() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-lg {{ $message->isFromAdmin() ? 'bg-blue-100' : 'bg-gray-100' }} p-4 rounded-lg">
                            @if($message->is_internal)
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="text-sm font-medium text-orange-600">Internal Note</span>
                            </div>
                            @endif
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                                <span class="text-sm text-gray-500">{{ $message->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ $message->created_at->format('M d, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Reply Form -->
            @if(!$ticket->isClosed())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add Reply</h3>
                <form action="{{ route('admin.support.reply', $ticket) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea name="message" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Type your reply..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_internal" value="1" id="is_internal" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_internal" class="ml-2 block text-sm text-gray-900">
                                Internal note (not visible to gym owner)
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Send Reply
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Status Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ticket Actions</h3>
                <div class="space-y-3">
                    @if($ticket->isOpen() || $ticket->isInProgress())
                        @if(!$ticket->isResolved())
                        <form action="{{ route('admin.support.resolve', $ticket) }}" method="POST" class="inline-block w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Mark as Resolved
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.support.close', $ticket) }}" method="POST" class="inline-block w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Close Ticket
                            </button>
                        </form>
                        @endif
                    @endif

                    @if($ticket->isResolved())
                    <form action="{{ route('admin.support.reopen', $ticket) }}" method="POST" class="inline-block w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Reopen Ticket
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Assignment & Priority -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Assignment & Priority</h3>
                <div class="space-y-4">
                    <!-- Assign Admin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign To</label>
                        <form action="{{ route('admin.support.assign', $ticket) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="assigned_to" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Unassigned</option>
                                @foreach($admins ?? [] as $admin)
                                <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium">
                                Assign
                            </button>
                        </form>
                    </div>

                    <!-- Update Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <form action="{{ route('admin.support.update-priority', $ticket) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="priority" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Links</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.tenants.show', $ticket->tenant) }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium text-center">
                        View Gym Details
                    </a>
                    <a href="{{ route('admin.activity.show', $ticket->tenant) }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium text-center">
                        View Activity Logs
                    </a>
                    <a href="{{ route('admin.impersonation.create', $ticket->tenant) }}" class="block w-full bg-orange-100 hover:bg-orange-200 text-orange-700 px-4 py-2 rounded-md text-sm font-medium text-center">
                        Impersonate Gym
                    </a>
                </div>
            </div>

            <!-- Internal Notes -->
            @if(!$ticket->isClosed())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add Internal Note</h3>
                <form action="{{ route('admin.support.add-note', $ticket) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Add internal note..."></textarea>
                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Add Note
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
@endsection