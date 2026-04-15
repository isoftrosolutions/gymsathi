@extends('layouts.gym')

@section('title', 'Edit Member')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.members.show', $member->id) }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Member
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-8 max-w-2xl">
    <h2 class="text-2xl font-headline font-bold text-white mb-8">Edit Member</h2>
    
    <form method="POST" action="{{ route('gym.members.update', $member->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Full Name *</label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Phone Number *</label>
            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="9800000000">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Email (Optional)</label>
            <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="member@example.com">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Address</label>
            <input type="text" name="address" value="{{ old('address', $member->address) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-on-variant mb-2">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
            <div>
                <label class="block text-sm text-on-variant mb-2">Gender</label>
                <select name="gender" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender', $member->gender) === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $member->gender) === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $member->gender) === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Emergency Contact</label>
            <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $member->emergency_contact) }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <button type="submit" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
            Update Member
        </button>
    </form>
</div>
@endsection
