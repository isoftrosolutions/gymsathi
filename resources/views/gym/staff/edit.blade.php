@extends('layouts.gym')

@section('title', 'Edit Staff')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.staff.show', $staff->id) }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Staff
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-8 max-w-2xl">
    <h2 class="text-2xl font-headline font-bold text-white mb-8">Edit Staff Member</h2>
    
    <form method="POST" action="{{ route('gym.staff.update', $staff->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Full Name *</label>
            <input type="text" name="name" value="{{ old('name', $staff->name) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Phone Number *</label>
            <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Email (Optional)</label>
            <input type="email" name="email" value="{{ old('email', $staff->email) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Role *</label>
            <select name="role_id" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="">Select role...</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $staff->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-on-variant mb-2">Specialization</label>
                <input type="text" name="specialization" value="{{ old('specialization', $staff->specialization) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
            <div>
                <label class="block text-sm text-on-variant mb-2">Salary</label>
                <input type="number" name="salary" value="{{ old('salary', $staff->salary) }}" min="0" step="0.01" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Join Date</label>
            <input type="date" name="join_date" value="{{ old('join_date', $staff->join_date?->format('Y-m-d')) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <button type="submit" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
            Update Staff Member
        </button>
    </form>
</div>
@endsection
