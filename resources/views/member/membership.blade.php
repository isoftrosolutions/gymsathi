@extends('layouts.member')

@section('title', 'Membership')
@section('topbar-title', 'Membership')

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-primary-container mb-2">Your Plan</p>
        <h1 class="font-syne font-black text-5xl md:text-6xl text-on-surface tracking-tighter leading-none uppercase">
            Membership
        </h1>
        <p class="text-on-surface-variant mt-3 text-base max-w-md">
            Manage your access, explore available plans from your gym.
        </p>
    </div>
</div>

{{-- ── BENTO GRID ── --}}
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">

    {{-- ── CURRENT PLAN PULSE CARD (col 8) ── --}}
    @if($package)
    @php
        $daysLeft   = max(0, now()->diffInDays($package->end_date, false));
        $totalDays  = max(1, $package->start_date->diffInDays($package->end_date));
        $pct        = round(($totalDays - $daysLeft) / $totalDays * 100);
        $isExpiring = $daysLeft <= 7;
    @endphp
    <div class="md:col-span-8 bg-surface-container-high/50 backdrop-blur-md rounded-[2rem] p-8 relative overflow-hidden flex flex-col justify-between min-h-[340px]"
         style="border-left: 4px solid #c8f135;">

        {{-- Watermark --}}
        <div class="absolute -top-2 right-8 opacity-[0.04] pointer-events-none select-none">
            <span class="material-symbols-outlined ms-fill" style="font-size:11rem;">workspace_premium</span>
        </div>

        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-widest mb-5
                {{ $isExpiring ? 'bg-error/15 border-error/30 text-error' : 'bg-secondary/10 border-secondary/20 text-secondary' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $isExpiring ? 'bg-error animate-pulse' : 'bg-secondary' }} inline-block"></span>
                {{ $isExpiring ? 'Expiring in '.$daysLeft.' days' : 'Active' }}
            </span>

            <h2 class="font-syne font-black text-4xl text-on-surface mb-2 leading-none">{{ $package->gymPackage->name }}</h2>
            <p class="text-on-surface-variant mb-8 max-w-md">
                {{ $package->gymPackage->description ?? $package->gymPackage->duration_text . ' full access membership.' }}
            </p>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                <div>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Start Date</p>
                    <p class="font-grotesk font-bold text-lg text-on-surface">{{ $package->start_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Renewal Date</p>
                    <p class="font-grotesk font-bold text-lg {{ $isExpiring ? 'text-error' : 'text-on-surface' }}">{{ $package->end_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Amount Paid</p>
                    <p class="font-grotesk font-bold text-lg text-primary-container">Rs. {{ number_format($package->amount_paid, 0) }}</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 mt-8 space-y-3">
            <div class="flex justify-between text-[10px] text-on-surface-variant">
                <span>{{ $package->start_date->format('M d') }}</span>
                <span class="font-bold text-on-surface">{{ $pct }}% complete · {{ $daysLeft }} days left</span>
                <span>{{ $package->end_date->format('M d, Y') }}</span>
            </div>
            <div class="w-full h-2.5 bg-surface-container-highest rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700
                    {{ $isExpiring ? 'bg-error shadow-[0_0_12px_rgba(255,180,171,0.4)]' : 'bg-secondary shadow-[0_0_12px_rgba(68,250,164,0.3)]' }}"
                     style="width: {{ $pct }}%"></div>
            </div>
        </div>
    </div>
    @else
    <div class="md:col-span-8 bg-surface-container-low rounded-[2rem] p-8 flex flex-col items-center justify-center text-center min-h-[340px] border border-error/20">
        <span class="material-symbols-outlined text-6xl text-error/30 mb-4">card_off</span>
        <h3 class="font-syne font-black text-2xl text-on-surface mb-2">No Active Membership</h3>
        <p class="text-on-surface-variant text-sm max-w-xs">You don't have an active plan. Contact your gym to get enrolled in one of the packages below.</p>
    </div>
    @endif

    {{-- ── QUICK STATS (col 4) ── --}}
    <div class="md:col-span-4 space-y-4">
        <div class="bg-surface-container-low rounded-[2rem] p-7">
            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-4">Total Spent</p>
            <p class="font-syne font-black text-4xl text-primary-container leading-none">
                Rs. {{ number_format($history->sum('amount_paid'), 0) }}
            </p>
            <p class="text-on-surface-variant text-sm mt-2">across {{ $history->count() }} package{{ $history->count() !== 1 ? 's' : '' }}</p>
        </div>
        <div class="bg-surface-container-low rounded-[2rem] p-7">
            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">Member Since</p>
            <p class="font-grotesk font-bold text-xl text-on-surface">{{ auth()->user()->created_at->format('M d, Y') }}</p>
            <p class="text-on-surface-variant text-xs mt-1">{{ auth()->user()->created_at->diffForHumans() }}</p>
        </div>
    </div>
</div>

{{-- ── AVAILABLE PLANS ── --}}
@if($availablePackages->isNotEmpty())
<div class="mb-6">
    <div class="flex items-center justify-between mb-8">
        <h3 class="font-syne font-black text-3xl text-on-surface tracking-tight uppercase">Available Plans</h3>
        <p class="text-on-surface-variant text-sm">Contact your gym admin to switch</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($availablePackages as $pkg)
        @php
            $isCurrent = $package && $package->gym_package_id === $pkg->id;
            $isFeatured = $pkg->is_featured;
        @endphp
        <div class="relative bg-surface-container-low rounded-[2rem] p-8 flex flex-col
            {{ $isCurrent ? 'ring-2 ring-primary-container/40 scale-[1.02] shadow-2xl shadow-black/40' : '' }}
            {{ $isFeatured && !$isCurrent ? 'border border-outline-variant/20' : '' }}">

            {{-- Featured badge --}}
            @if($isCurrent)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 kinetic-gradient px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-on-primary whitespace-nowrap">
                    Your Active Plan
                </div>
            @elseif($isFeatured)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-surface-container-highest px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/30 whitespace-nowrap">
                    Featured
                </div>
            @endif

            <div class="mb-6">
                <h4 class="font-syne font-bold text-xl text-on-surface mb-1">{{ $pkg->name }}</h4>
                <p class="text-on-surface-variant text-sm">{{ $pkg->description ?? $pkg->duration_text . ' membership' }}</p>
            </div>

            <div class="mb-6">
                <span class="font-syne font-black text-4xl text-on-surface">Rs. {{ number_format($pkg->price, 0) }}</span>
                <span class="text-on-surface-variant text-sm ml-1">/ {{ $pkg->duration_text }}</span>
            </div>

            @if($pkg->features && count($pkg->features) > 0)
            <ul class="space-y-3 mb-8 flex-grow">
                @foreach($pkg->features as $feature)
                <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                    <span class="material-symbols-outlined ms-fill text-secondary text-lg">check_circle</span>
                    {{ $feature }}
                </li>
                @endforeach
            </ul>
            @else
            <div class="flex-grow"></div>
            @endif

            <div class="mt-auto pt-4">
                @if($isCurrent)
                    <button disabled class="w-full py-4 rounded-2xl bg-surface-container text-on-surface-variant font-black text-sm flex items-center justify-center gap-2 cursor-default">
                        <span class="material-symbols-outlined text-lg">check</span>
                        Currently Active
                    </button>
                @else
                    <button type="button"
                        onclick="initiateRenew({{ $pkg->id }}, {{ $pkg->price }})"
                        class="w-full py-4 rounded-2xl bg-primary-container text-on-primary font-black text-sm flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-lg">bolt</span>
                        Renew with eSewa
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ── PAYMENT HISTORY TABLE ── --}}
<div class="bg-surface-container-low rounded-[2rem] p-8">
    <h3 class="font-syne font-black text-xl text-on-surface tracking-tight mb-8 uppercase">Payment History</h3>

    @if($history->isNotEmpty())
        <div class="space-y-3">
            @foreach($history as $pay)
            @php
                $sc = match($pay->status) {
                    'active'  => ['bg'=>'bg-secondary/10', 'text'=>'text-secondary', 'bd'=>'border-secondary/20'],
                    'expired' => ['bg'=>'bg-error/10',     'text'=>'text-error',     'bd'=>'border-error/20'],
                    'frozen'  => ['bg'=>'bg-outline/10',   'text'=>'text-outline',   'bd'=>'border-outline/20'],
                    default   => ['bg'=>'bg-surface-container-highest', 'text'=>'text-on-surface-variant', 'bd'=>'border-outline-variant/20'],
                };
            @endphp
            <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-5 bg-surface-container rounded-2xl hover:bg-surface-container-high transition-colors gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary-container/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary-container text-xl">receipt_long</span>
                    </div>
                    <div>
                        <p class="text-on-surface font-bold text-sm">{{ $pay->gymPackage->name ?? 'Package' }}</p>
                        <p class="text-on-surface-variant text-xs mt-0.5">
                            {{ $pay->start_date->format('M d, Y') }}
                            <span class="mx-1 opacity-40">→</span>
                            {{ $pay->end_date->format('M d, Y') }}
                            &nbsp;·&nbsp; {{ $pay->gymPackage->duration_text ?? '' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4 sm:text-right">
                    <p class="font-grotesk font-black text-on-surface text-base">Rs. {{ number_format($pay->amount_paid, 0) }}</p>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $sc['bg'] }} {{ $sc['text'] }} {{ $sc['bd'] }}">
                        {{ $pay->status }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/20 mb-4">payments</span>
            <p class="text-on-surface-variant">No payment records found.</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
async function initiateRenew(packageId, amount) {
    try {
        const response = await fetch('{{ route("payment.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                gateway: 'esewa',
                package_id: packageId,
                amount: amount
            })
        });

        const data = await response.json();

        if (data.success && data.payment_url) {
            window.location.href = data.payment_url;
        } else {
            alert(data.message || 'Failed to initiate payment');
        }
    } catch (error) {
        console.error('Payment error:', error);
        alert('An error occurred. Please try again.');
    }
}
</script>
@endpush

@endsection
