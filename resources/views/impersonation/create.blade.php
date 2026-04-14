@extends('layouts.admin')

@section('title', 'Impersonate — ' . $tenant->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-xl">
    <div class="mb-8">
        <a href="{{ route('admin.tenants.show', $tenant) }}" class="text-sm text-gray-500 hover:text-gray-700">← {{ $tenant->name }}</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-1">Start Impersonation Session</h1>
        <p class="text-gray-600 text-sm mt-1">You will be logged in as a user of <strong>{{ $tenant->name }}</strong>. All actions will be recorded.</p>
    </div>

    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6 text-sm text-orange-800">
        <strong>Warning:</strong> Impersonation gives you full access to this gym's account. Only use this for legitimate support purposes. Your session will be logged.
    </div>

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">{{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.impersonation.start', $tenant) }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select User to Impersonate</label>
                <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Default admin user</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role?->name ?? 'No role' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="3" required maxlength="500"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="e.g. Investigating support ticket #42, member check-in issue reported by gym owner.">{{ old('reason') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">This is recorded in the audit log.</p>
            </div>

            <div class="flex justify-end gap-4 pt-2">
                <a href="{{ route('admin.tenants.show', $tenant) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">Cancel</a>
                <button type="submit"
                        onclick="return confirm('Start impersonation session for {{ addslashes($tenant->name) }}? Your actions will be logged.')"
                        class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                    Start Session
                </button>
            </div>
        </form>
    </div>

    <p class="mt-4 text-xs text-gray-500 text-center">
        <a href="{{ route('admin.impersonation.logs') }}" class="text-blue-600 hover:underline">View all impersonation logs →</a>
    </p>
</div>
@endsection
