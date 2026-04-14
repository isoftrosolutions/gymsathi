@extends('layouts.admin')

@section('title', 'Invoice - ' . $tenant->name)

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg">
        <!-- Invoice Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold">INVOICE</h1>
                    <p class="text-blue-100 mt-2">Invoice #{{ str_pad($tenant->id, 6, '0', STR_PAD_LEFT) }}-{{ $generated_at->format('Ymd') }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold">GymSathi</h2>
                    <p class="text-blue-100">Subscription Management Platform</p>
                    <p class="text-blue-100 text-sm">Kathmandu, Nepal</p>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="p-8">
            <div class="grid grid-cols-2 gap-8 mb-8">
                <!-- Bill To -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill To:</h3>
                    <div class="text-gray-700">
                        <p class="font-medium">{{ $tenant->name }}</p>
                        <p>{{ $tenant->address }}</p>
                        <p>{{ $tenant->city }}, Nepal</p>
                        <p class="mt-2">Owner: {{ $tenant->owner_name }}</p>
                        <p>Phone: {{ $tenant->owner_phone }}</p>
                    </div>
                </div>

                <!-- Invoice Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Details:</h3>
                    <div class="space-y-2 text-gray-700">
                        <div class="flex justify-between">
                            <span>Invoice Date:</span>
                            <span>{{ $generated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Billing Period:</span>
                            <span>{{ $billing_period['start']->format('M d, Y') }} - {{ $billing_period['end']->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Due Date:</span>
                            <span>{{ $billing_period['end']->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between font-medium">
                            <span>Status:</span>
                            <span class="text-green-600">{{ $subscription->status === 'active' ? 'Paid' : 'Pending' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Details -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscription Details</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Plan</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $plan->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Monthly Price</p>
                            <p class="text-lg font-semibold text-gray-900">₨ {{ number_format($plan->price, 0) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Billing Cycle</p>
                            <p class="text-lg font-semibold text-gray-900">Monthly</p>
                        </div>
                    </div>

                    @if($plan->max_members)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">Maximum Members: {{ $plan->max_members }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Invoice Table -->
            <div class="mb-8">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-900">Description</th>
                            <th class="border border-gray-300 px-4 py-3 text-right text-sm font-semibold text-gray-900">Quantity</th>
                            <th class="border border-gray-300 px-4 py-3 text-right text-sm font-semibold text-gray-900">Unit Price</th>
                            <th class="border border-gray-300 px-4 py-3 text-right text-sm font-semibold text-gray-900">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">
                                {{ $plan->name }} Plan Subscription<br>
                                <span class="text-gray-600 text-xs">Billing period: {{ $billing_period['start']->format('M d, Y') }} - {{ $billing_period['end']->format('M d, Y') }}</span>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900 text-right">1</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900 text-right">₨ {{ number_format($amount, 0) }}</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-900 text-right">₨ {{ number_format($amount, 0) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="border border-gray-300 px-4 py-3 text-right text-sm font-semibold text-gray-900">Total Amount</td>
                            <td class="border border-gray-300 px-4 py-3 text-right text-lg font-bold text-gray-900">₨ {{ number_format($amount, 0) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">Payment Instructions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-blue-900 mb-2">Bank Transfer</h4>
                        <div class="text-sm text-blue-800">
                            <p>Account Name: GymSathi Pvt. Ltd.</p>
                            <p>Account Number: 1234567890</p>
                            <p>Bank: Global IME Bank</p>
                            <p>Branch: Kathmandu</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-900 mb-2">Digital Payment</h4>
                        <div class="text-sm text-blue-800">
                            <p>eSewa ID: 9841000000</p>
                            <p>Khalti ID: 9841000000</p>
                            <p>Please include invoice number in payment reference</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Included -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Plan Features Included</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($plan->features as $feature)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-gray-700">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t pt-8 text-center text-gray-600">
                <p class="text-sm">Thank you for choosing GymSathi! For support, contact us at support@gymsathi.com</p>
                <p class="text-xs mt-2">This invoice was generated on {{ $generated_at->format('M d, Y \a\t H:i') }}</p>
            </div>
        </div>

        <!-- Print/Send Actions -->
        <div class="bg-gray-50 px-8 py-4 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Invoice generated by GymSathi Platform
            </div>
            <div class="flex space-x-4">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Print Invoice
                </button>
                <form action="{{ route('admin.billing.send-invoice', $tenant) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Send via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .min-h-screen, .min-h-screen * { visibility: visible; }
    .min-h-screen { position: absolute; left: 0; top: 0; }
    .flex.justify-between.items-center { display: none; }
}
</style>
@endsection