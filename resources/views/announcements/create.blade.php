@extends('layouts.admin')

@section('title', 'New Announcement')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('admin.announcements.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Announcements</a>
        <h1 class="text-3xl font-bold text-gray-900 mt-1">New Announcement</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-lg shadow p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required maxlength="255"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       placeholder="e.g. Scheduled Maintenance Tonight">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" rows="5" required maxlength="2000"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Write your message to gyms...">{{ old('message') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Max 2000 characters.</p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" required class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select type...</option>
                        <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>General</option>
                        <option value="maintenance" {{ old('type') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="feature" {{ old('type') === 'feature' ? 'selected' : '' }}>New Feature</option>
                        <option value="offer" {{ old('type') === 'offer' ? 'selected' : '' }}>Offer / Promo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
                    <select name="channels" required class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="in_app" {{ old('channels') === 'in_app' ? 'selected' : '' }}>In-App Only</option>
                        <option value="whatsapp" {{ old('channels') === 'whatsapp' ? 'selected' : '' }}>WhatsApp Only</option>
                        <option value="both" {{ old('channels') === 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Schedule (optional)</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}"
                       class="w-full border-gray-300 rounded-md shadow-sm">
                <p class="text-xs text-gray-400 mt-1">Leave blank to save as draft.</p>
            </div>

            <!-- Recipient Filters -->
            <div class="border-t pt-4">
                <p class="text-sm font-medium text-gray-700 mb-3">Recipient Filters <span class="text-xs text-gray-400">(leave blank = all active gyms)</span></p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Plan</label>
                        <select name="recipient_filters[plan]" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All Plans</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->slug }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">City</label>
                        <select name="recipient_filters[city]" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Status</label>
                        <select name="recipient_filters[status]" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Active Only</option>
                            <option value="suspended">Suspended</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">Save Announcement</button>
        </div>
    </form>
</div>
@endsection
