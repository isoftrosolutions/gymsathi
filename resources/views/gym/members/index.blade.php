@extends('layouts.gym')

@section('title', 'Members')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-headline font-bold text-white">Members</h1>
        <p class="text-on-variant mt-1">Manage your gym members</p>
    </div>
    <a href="{{ route('gym.members.create') }}" class="kinetic-gradient text-black font-headline font-bold px-6 py-3 rounded-xl hover:scale-105 transition-all">
        + Add Member
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="text-[10px] uppercase tracking-widest text-on-variant font-label border-b border-primary-border/50 bg-black/5">
                <th class="px-8 py-6">Member</th>
                <th class="px-8 py-6">Package</th>
                <th class="px-8 py-6">Status</th>
                <th class="px-8 py-6">Joined</th>
                <th class="px-8 py-6 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-primary-border/30">
            @forelse($members as $member)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-lime/10 flex items-center justify-center text-primary-lime font-bold">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $member->name }}</div>
                            <div class="text-xs text-on-variant">{{ $member->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-8 py-6">
                    @if($member->activeMemberPackage)
                        <span class="text-sm text-white">{{ $member->activeMemberPackage->gymPackage->name }}</span>
                    @else
                        <span class="text-sm text-on-variant">No package</span>
                    @endif
                </td>
                <td class="px-8 py-6">
                    @if($member->activeMemberPackage && $member->activeMemberPackage->isActive())
                        <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest rounded-full bg-primary-lime/10 border border-primary-lime text-primary-lime">
                            Active
                        </span>
                    @else
                        <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest rounded-full bg-red-500/10 border border-red-500 text-red-500">
                            Inactive
                        </span>
                    @endif
                </td>
                <td class="px-8 py-6 text-sm text-on-variant">
                    {{ $member->created_at->format('M d, Y') }}
                </td>
                <td class="px-8 py-6 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('gym.members.show', $member->id) }}" class="p-2 text-on-variant hover:text-primary-lime transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('gym.members.edit', $member->id) }}" class="p-2 text-on-variant hover:text-primary-lime transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-8 py-12 text-center text-on-variant">
                    No members found. Add your first member to get started.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-6 border-t border-primary-border">
        {{ $members->links() }}
    </div>
</div>
@endsection
