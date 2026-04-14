@extends('layouts.admin')

@section('title', 'Edit — ' . $announcement->title)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('admin.announcements.show', $announcement) }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
        <h1 class="text-3xl font-bold text-gray-900 mt-1">Edit Announcement</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" class="space-y-6">
        @csrf @method('PATCH')

        <div class="bg-white rounded-lg shadow p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required maxlength="255"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" rows="5" required maxlength="2000"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('message', $announcement->message) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" required class="w-full border-gray-300 rounded-md shadow-sm">
                        @foreach(['general','maintenance','feature','offer'] as $t)
                        <option value="{{ $t }}" {{ old('type', $announcement->type) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
                    <select name="channels" required class="w-full border-gray-300 rounded-md shadow-sm">
                        @foreach(['in_app' => 'In-App Only', 'whatsapp' => 'WhatsApp Only', 'both' => 'Both'] as $val => $label)
                        <option value="{{ $val }}" {{ old('channels', $announcement->channels) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
                <input type="datetime-local" name="scheduled_at"
                       value="{{ old('scheduled_at', $announcement->scheduled_at?->format('Y-m-d\TH:i')) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="border-t pt-4">
                <p class="text-sm font-medium text-gray-700 mb-3">Recipient Filters</p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Plan</label>
                        <select name="recipient_filters[plan]" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All Plans</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->slug }}" {{ ($announcement->recipient_filters['plan'] ?? '') === $plan->slug ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">City</label>
                        <select name="recipient_filters[city]" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}" {{ ($announcement->recipient_filters['city'] ?? '') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Status</label>
                        <select name="recipient_filters[status]" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Active Only</option>
                            <option value="suspended" {{ ($announcement->recipient_filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="expired" {{ ($announcement->recipient_filters['status'] ?? '') === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.announcements.show', $announcement) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">Save Changes</button>
        </div>
    </form>
</div>
@endsection
