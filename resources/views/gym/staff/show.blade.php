@extends('layouts.gym')

@section('title', $staff->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.staff.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Staff
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-24 h-24 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold text-3xl mb-4">
                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-headline font-bold text-white">{{ $staff->name }}</h2>
                <span class="mt-3 px-4 py-1 text-xs uppercase font-bold tracking-widest rounded-full bg-secondary/10 border border-secondary/30 text-secondary">
                    {{ $staff->role->name ?? 'Staff' }}
                </span>
            </div>

            <div class="space-y-4">
                @if($staff->email)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-white">{{ $staff->email }}</span>
                </div>
                @endif

                @if($staff->phone)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-sm text-white">{{ $staff->phone }}</span>
                </div>
                @endif

                @if($staff->specialization)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    <span class="text-sm text-white">{{ $staff->specialization }}</span>
                </div>
                @endif

                @if($staff->salary)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm text-white">Rs. {{ number_format($staff->salary, 0) }}</span>
                </div>
                @endif

                @if($staff->join_date)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-white">Joined {{ $staff->join_date->format('M d, Y') }}</span>
                </div>
                @endif
            </div>

            <div class="mt-8 pt-6 border-t border-primary-border flex gap-3">
                <a href="{{ route('gym.staff.edit', $staff->id) }}" class="flex-1 bg-white/10 border border-primary-border text-white font-bold py-3 rounded-xl text-center hover:bg-white/20 transition-all">
                    Edit
                </a>
                <form action="{{ route('gym.staff.destroy', $staff->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500/10 border border-red-500 text-red-500 font-bold py-3 rounded-xl hover:bg-red-500/20 transition-all">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <h3 class="text-xl font-headline font-bold text-white mb-6">Details</h3>
            
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <span class="text-sm text-on-variant">Created</span>
                        <p class="text-white">{{ $staff->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-on-variant">Member ID</span>
                        <p class="text-white">#{{ $staff->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
