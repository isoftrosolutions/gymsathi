@extends('layouts.admin')

@section('title', $announcement->title)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-6 flex justify-between items-start">
        <div>
            <a href="{{ route('admin.announcements.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Announcements</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $announcement->title }}</h1>
            <div class="flex items-center gap-3 mt-2">
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $announcement->getStatusBadgeClass() }}">{{ ucfirst($announcement->status) }}</span>
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $announcement->getTypeBadgeClass() }}">{{ ucfirst($announcement->type) }}</span>
                <span class="text-xs text-gray-500">by {{ $announcement->creator?->name ?? 'System' }}</span>
            </div>
        </div>
        <div class="flex gap-2">
            @if(!$announcement->isSent())
            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">Edit</a>
            <form action="{{ route('admin.announcements.send', $announcement) }}" method="POST" class="inline"
                  onsubmit="return confirm('Send this announcement to {{ $announcement->recipients_count ?? 'all' }} recipients now?')">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Send Now</button>
            </form>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div id="toast" class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm flex justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="font-bold">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
        <div class="px-6 py-5">
            <p class="text-xs font-medium text-gray-500 uppercase mb-2">Message</p>
            <p class="text-gray-800 whitespace-pre-wrap">{{ $announcement->message }}</p>
        </div>

        <div class="px-6 py-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div><p class="text-xs text-gray-500 uppercase">Channel</p><p class="font-medium mt-1">{{ ucfirst(str_replace('_', ' ', $announcement->channels)) }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Recipients</p><p class="font-medium mt-1">{{ $announcement->recipients_count ?? '—' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Scheduled</p><p class="font-medium mt-1">{{ $announcement->scheduled_at?->format('M d, Y H:i') ?? 'Not scheduled' }}</p></div>
            <div><p class="text-xs text-gray-500 uppercase">Sent At</p><p class="font-medium mt-1">{{ $announcement->sent_at?->format('M d, Y H:i') ?? '—' }}</p></div>
        </div>

        @if($announcement->recipient_filters)
        <div class="px-6 py-4">
            <p class="text-xs font-medium text-gray-500 uppercase mb-2">Recipient Filters</p>
            <div class="flex gap-2 flex-wrap">
                @foreach(array_filter($announcement->recipient_filters) as $key => $val)
                <span class="px-2 py-1 bg-gray-100 rounded text-xs text-gray-700">{{ ucfirst($key) }}: {{ $val }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @if(!$announcement->isSent())
    <div class="mt-4 flex justify-end">
        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST"
              onsubmit="return confirm('Delete this announcement?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
        </form>
    </div>
    @endif
</div>
@endsection
