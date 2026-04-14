@extends('layouts.admin')

@section('title', 'Record Payment — ' . $tenant->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-8">
        <a href="{{ route('admin.billing.payments', $tenant) }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Payments</a>
        <h1 class="text-3xl font-bold text-gray-900 mt-1">Record Manual Payment</h1>
        <p class="text-gray-600">{{ $tenant->name }} · {{ $tenant->city }}</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.billing.record-payment', $tenant) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount (NPR)</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g. 2500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select name="method" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select method...</option>
                    <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="bank_transfer" {{ old('method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="manual" {{ old('method') === 'manual' ? 'selected' : '' }}>Manual / Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Reference number, remarks...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-4 pt-2">
                <a href="{{ route('admin.billing.payments', $tenant) }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                    Record Payment
                </button>
            </div>
        </form>
    </div>

    <p class="mt-4 text-xs text-gray-500">Recording a payment will automatically extend the active subscription by one month.</p>
</div>
@endsection
