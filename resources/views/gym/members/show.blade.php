@extends('layouts.gym')

@section('title', $member->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.members.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Members
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <div class="flex flex-col items-center text-center mb-8">
                @if($member->profile_picture)
                    <img src="{{ asset(Storage::url($member->profile_picture)) }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-primary-lime">
                @else
                    <div class="w-24 h-24 rounded-full bg-primary-lime/10 flex items-center justify-center text-primary-lime font-bold text-3xl mb-4">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
                <h2 class="text-2xl font-headline font-bold text-white">{{ $member->name }}</h2>
                <p class="text-on-variant">{{ $member->email }}</p>
                @if($member->activeMemberPackage && $member->activeMemberPackage->isActive())
                    <span class="mt-3 px-4 py-1 text-xs uppercase font-bold tracking-widest rounded-full bg-primary-lime/10 border border-primary-lime text-primary-lime">
                        Active Member
                    </span>
                @else
                    <span class="mt-3 px-4 py-1 text-xs uppercase font-bold tracking-widest rounded-full bg-red-500/10 border border-red-500 text-red-500">
                        Inactive
                    </span>
                @endif
            </div>

            <div class="space-y-4">
                @if($member->phone)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-sm text-white">{{ $member->phone }}</span>
                </div>
                @endif

                @if($member->address)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-sm text-white">{{ $member->address }}</span>
                </div>
                @endif

                @if($member->date_of_birth)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/></svg>
                    <span class="text-sm text-white">{{ $member->date_of_birth->format('M d, Y') }}</span>
                </div>
                @endif

                @if($member->gender)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-sm text-white capitalize">{{ $member->gender }}</span>
                </div>
                @endif

                @if($member->emergency_contact)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-sm text-white">{{ $member->emergency_contact }}</span>
                </div>
                @endif

                @if($member->blood_group)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    <span class="text-sm text-white">{{ $member->blood_group }}</span>
                </div>
                @endif
            </div>

            <div class="mt-8 pt-6 border-t border-primary-border flex gap-3">
                <a href="{{ route('gym.members.edit', $member->id) }}" class="flex-1 bg-white/10 border border-primary-border text-white font-bold py-3 rounded-xl text-center hover:bg-white/20 transition-all">
                    Edit
                </a>
                <form action="{{ route('gym.members.destroy', $member->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this member?');">
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
            <h3 class="text-xl font-headline font-bold text-white mb-6">Membership History</h3>
            
            @if($member->memberPackages->isNotEmpty())
                <div class="space-y-4">
                    @foreach($member->memberPackages as $package)
                    <div class="bg-black/20 rounded-xl p-6 border border-primary-border/30">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-white">{{ $package->gymPackage->name }}</h4>
                                <p class="text-sm text-on-variant">{{ $package->gymPackage->duration_text }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs uppercase font-bold tracking-widest rounded-full 
                                {{ $package->status === 'active' ? 'bg-primary-lime/10 border border-primary-lime text-primary-lime' : '' }}
                                {{ $package->status === 'expired' ? 'bg-red-500/10 border border-red-500 text-red-500' : '' }}
                                {{ $package->status === 'frozen' ? 'bg-blue-500/10 border border-blue-500 text-blue-500' : '' }}">
                                {{ $package->status }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-on-variant">Paid</span>
                                <p class="text-white font-bold">Rs. {{ number_format($package->amount_paid, 0) }}</p>
                            </div>
                            <div>
                                <span class="text-on-variant">Start</span>
                                <p class="text-white">{{ $package->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-on-variant">End</span>
                                <p class="text-white">{{ $package->end_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-on-variant">
                    No membership packages yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
