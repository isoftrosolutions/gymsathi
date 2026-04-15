@extends('layouts.gym')

@section('title', 'Edit Payment')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.payments.show', $payment->id) }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Payment
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-8 max-w-2xl">
    <h2 class="text-2xl font-headline font-bold text-white mb-8">Edit Payment</h2>
    
    <form method="POST" action="{{ route('gym.payments.update', $payment->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Member *</label>
            <select name="user_id" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="">Select member...</option>
                @foreach($members as $member)
                <option value="{{ $member->id }}" {{ old('user_id', $payment->user_id) == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Package *</label>
            <select name="gym_package_id" id="package-select" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="">Select package...</option>
                @foreach($packages as $pkg)
                <option value="{{ $pkg->id }}" data-price="{{ $pkg->price }}" {{ old('gym_package_id', $payment->gym_package_id) == $pkg->id ? 'selected' : '' }}>
                    {{ $pkg->name }} - Rs. {{ number_format($pkg->price, 0) }} ({{ $pkg->duration_text }})
                </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Amount Paid (Rs.) *</label>
            <input type="number" name="amount_paid" id="amount-paid" value="{{ old('amount_paid', $payment->amount_paid) }}" required min="0" step="0.01" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-on-variant mb-2">Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date', $payment->start_date->format('Y-m-d')) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
            <div>
                <label class="block text-sm text-on-variant mb-2">End Date *</label>
                <input type="date" name="end_date" value="{{ old('end_date', $payment->end_date->format('Y-m-d')) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Status *</label>
            <select name="status" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="active" {{ old('status', $payment->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ old('status', $payment->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="frozen" {{ old('status', $payment->status) === 'frozen' ? 'selected' : '' }}>Frozen</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Payment Method</label>
            <select name="payment_method" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="">Select method...</option>
                <option value="cash" {{ old('payment_method', $payment->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="esewa" {{ old('payment_method', $payment->payment_method) === 'esewa' ? 'selected' : '' }}>eSewa</option>
                <option value="khalti" {{ old('payment_method', $payment->payment_method) === 'khalti' ? 'selected' : '' }}>Khalti</option>
                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="other" {{ old('payment_method', $payment->payment_method) === 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        
        <button type="submit" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
            Update Payment
        </button>
    </form>
</div>
@endsection
