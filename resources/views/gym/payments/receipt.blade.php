@extends('layouts.print')

@section('title', 'Payment Receipt')

@section('content')
@php
    $receiptNo = 'RCP-'.$tenant->id.'-'.str_pad((string) $payment->id, 6, '0', STR_PAD_LEFT);
    $issuedAt = $payment->created_at ?? now();
@endphp

<div class="no-print mx-auto max-w-[210mm] px-4 pt-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('gym.payments.show', $payment->id) }}" class="text-sm text-[#2e3036] hover:underline">
            &larr; Back to Payment
        </a>
        <button type="button" onclick="window.print()" class="rounded-xl bg-[#111318] px-4 py-2 text-sm font-bold text-white">
            Print (A4)
        </button>
    </div>
</div>

<div class="mx-auto max-w-[210mm] px-4 py-6">
    <div class="rounded-[20px] bg-white border border-black/10 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-7 border-b border-black/10">
            <div class="flex items-start justify-between gap-8">
                <div>
                    <div class="font-headline text-2xl font-bold tracking-tight">{{ $tenant->name ?? 'Gym' }}</div>
                    <div class="mt-1 text-sm text-black/70">
                        @php
                            $addr = trim(($tenant->address ?? '').' '.(($tenant->city ?? '') ? '('.$tenant->city.')' : ''));
                        @endphp
                        {{ $addr !== '' ? $addr : 'Address: Not provided' }}
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center gap-2 rounded-full bg-[#C8F135]/25 px-3 py-1 text-xs font-bold uppercase tracking-widest text-black">
                        Payment Receipt
                    </div>
                    <div class="mt-3 text-sm">
                        <div class="text-black/60">Receipt No.</div>
                        <div class="font-bold">{{ $receiptNo }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-6 text-sm">
                <div class="rounded-xl bg-black/[0.03] px-5 py-4">
                    <div class="text-black/60">Billed to</div>
                    <div class="mt-1 font-bold text-base">{{ $payment->user->name }}</div>
                    <div class="mt-0.5 text-black/70">
                        {{ $payment->user->phone ?? 'Phone: Not provided' }}
                    </div>
                    <div class="text-black/70">
                        {{ $payment->user->email ?? 'Email: Not provided' }}
                    </div>
                </div>
                <div class="rounded-xl bg-black/[0.03] px-5 py-4">
                    <div class="text-black/60">Receipt details</div>
                    <div class="mt-1 grid grid-cols-2 gap-x-4 gap-y-1">
                        <div class="text-black/60">Payment ID</div>
                        <div class="text-right font-bold">#{{ $payment->id }}</div>
                        <div class="text-black/60">Issued</div>
                        <div class="text-right font-bold">{{ $issuedAt->format('M d, Y H:i') }}</div>
                        <div class="text-black/60">Issued by</div>
                        <div class="text-right font-bold">{{ $issuedBy->name ?? 'System' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line items -->
        <div class="px-8 py-7">
            <div class="text-xs font-bold uppercase tracking-widest text-black/60">Membership</div>

            <div class="mt-4 overflow-hidden rounded-2xl border border-black/10">
                <table class="w-full text-sm">
                    <thead class="bg-black/[0.03]">
                        <tr class="text-left text-xs uppercase tracking-widest text-black/60">
                            <th class="px-5 py-4 font-bold">Description</th>
                            <th class="px-5 py-4 font-bold">Period</th>
                            <th class="px-5 py-4 font-bold text-right">Amount (NPR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-black/10">
                            <td class="px-5 py-4">
                                <div class="font-bold">{{ $payment->gymPackage->name ?? 'Package' }}</div>
                                <div class="mt-1 text-black/60">
                                    Duration: {{ $payment->gymPackage->duration_text ?? 'Not provided' }}
                                </div>
                                <div class="mt-2 inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest
                                    {{ $payment->status === 'active' ? 'text-emerald-700' : '' }}
                                    {{ $payment->status === 'expired' ? 'text-red-700' : '' }}
                                    {{ $payment->status === 'frozen' ? 'text-blue-700' : '' }}
                                    {{ $payment->status === 'cancelled' ? 'text-black/70' : '' }}">
                                    Status: {{ ucfirst($payment->status) }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-black/80">
                                <div>{{ $payment->start_date?->format('M d, Y') ?? '—' }} - {{ $payment->end_date?->format('M d, Y') ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="font-bold text-base">{{ number_format((float) $payment->amount_paid, 0) }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-6">
                <div class="rounded-2xl border border-black/10 p-5">
                    <div class="text-xs font-bold uppercase tracking-widest text-black/60">Payment method</div>
                    <div class="mt-2 text-sm text-black/80">
                        @if (!empty($payment->payment_method))
                            {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                        @else
                            Not captured for member payments in current schema
                        @endif
                    </div>
                </div>

                <div class="rounded-2xl border border-black/10 p-5">
                    <div class="text-xs font-bold uppercase tracking-widest text-black/60">Total</div>
                    <div class="mt-2 flex items-end justify-between">
                        <div class="text-sm text-black/60">Amount paid</div>
                        <div class="font-headline text-3xl font-bold tracking-tight">
                            NPR {{ number_format((float) $payment->amount_paid, 0) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-6">
                <div class="rounded-2xl bg-black/[0.03] p-5">
                    <div class="text-xs font-bold uppercase tracking-widest text-black/60">Notes</div>
                    <div class="mt-2 text-sm text-black/70 leading-relaxed">
                        This is a system-generated receipt. Keep it for your records.
                    </div>
                </div>
                <div class="rounded-2xl bg-black/[0.03] p-5">
                    <div class="text-xs font-bold uppercase tracking-widest text-black/60">Signatures</div>
                    <div class="mt-6 grid grid-cols-2 gap-6 text-sm">
                        <div class="border-t border-black/30 pt-2 text-black/70">Received by</div>
                        <div class="border-t border-black/30 pt-2 text-black/70 text-right">Authorized</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 py-5 border-t border-black/10 flex items-center justify-between text-xs text-black/60">
            <div>Powered by GymSathi</div>
            <div>{{ now()->format('M d, Y') }}</div>
        </div>
    </div>
</div>
@endsection

