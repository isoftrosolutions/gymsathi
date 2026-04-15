@extends('layouts.gym')

@section('title', 'Check In/Out')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.attendance.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Attendance
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-8 max-w-2xl">
    <h2 class="text-2xl font-headline font-bold text-white mb-8">Check In / Check Out</h2>
    
    <form method="POST" action="{{ route('gym.attendance.store') }}" class="space-y-6">
        @csrf
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Select Member *</label>
            <select name="user_id" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="">Choose member...</option>
                @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <button type="submit" name="action" value="check_in" class="kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
                Check In
            </button>
            <button type="submit" name="action" value="check_out" class="bg-white/10 border border-primary-border text-white font-headline font-bold py-4 rounded-xl hover:bg-white/20 transition-all">
                Check Out
            </button>
        </div>
    </form>
</div>
@endsection
