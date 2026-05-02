@extends('layouts.member')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="mb-10">
    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-primary-container mb-2">
        Welcome back, {{ explode(' ', auth()->user()->name)[0] }}
    </p>
    <h1 class="font-syne font-black text-5xl md:text-6xl text-on-surface tracking-tighter leading-none uppercase">
        Your <span class="text-primary-container">Pulse</span>
    </h1>
    <p class="text-on-surface-variant mt-3 text-base max-w-md">
        {{ now()->format('l, F j') }} — stay consistent, stay kinetic.
    </p>
</div>

{{-- ── BENTO GRID ROW 1 ── --}}
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">

    {{-- ── MEMBERSHIP CARD (col 8) ── --}}
    @if($package)
    @php
        $daysLeft   = max(0, now()->diffInDays($package->end_date, false));
        $totalDays  = max(1, $package->start_date->diffInDays($package->end_date));
        $pct        = round(($totalDays - $daysLeft) / $totalDays * 100);
        $isExpiring = $daysLeft <= 7;
    @endphp
    <div class="md:col-span-8 relative bg-surface-container-high rounded-[2rem] p-8 overflow-hidden"
         style="border-left: 4px solid #c8f135;">

        {{-- watermark icon --}}
        <div class="absolute -top-4 right-8 opacity-5 pointer-events-none">
            <span class="material-symbols-outlined ms-fill" style="font-size:10rem;">workspace_premium</span>
        </div>

        <div class="relative z-10">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                        {{ $isExpiring ? 'bg-error/15 text-error border border-error/30' : 'bg-secondary/10 text-secondary border border-secondary/20' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isExpiring ? 'bg-error' : 'bg-secondary' }} inline-block"></span>
                        {{ $isExpiring ? 'Expiring Soon' : 'Active' }}
                    </span>
                    <h2 class="font-syne font-black text-3xl text-on-surface mt-3 leading-none">
                        {{ $package->gymPackage->name }}
                    </h2>
                    <p class="text-on-surface-variant text-sm mt-1">
                        {{ $package->gymPackage->duration_text }} plan
                        @if($package->gymPackage->description)
                            · {{ Str::limit($package->gymPackage->description, 50) }}
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Days Left</p>
                    <p class="font-syne font-black text-5xl {{ $isExpiring ? 'text-error' : 'text-primary-container' }} leading-none">
                        {{ $daysLeft }}
                    </p>
                </div>
            </div>

            {{-- Progress --}}
            <div class="mb-6">
                <div class="flex justify-between text-[10px] text-on-surface-variant mb-2">
                    <span>{{ $package->start_date->format('M d') }}</span>
                    <span class="font-bold">{{ $pct }}% complete</span>
                    <span>{{ $package->end_date->format('M d, Y') }}</span>
                </div>
                <div class="w-full h-2 bg-surface-container-highest rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700
                        {{ $isExpiring ? 'bg-error shadow-[0_0_10px_rgba(255,180,171,0.4)]' : 'bg-secondary shadow-[0_0_10px_rgba(68,250,164,0.3)]' }}"
                         style="width: {{ $pct }}%"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                <div>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Amount Paid</p>
                    <p class="font-grotesk font-bold text-lg text-on-surface">
                        Rs. {{ number_format($package->amount_paid, 0) }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Renewal Date</p>
                    <p class="font-grotesk font-bold text-lg text-on-surface">
                        {{ $package->end_date->format('M d, Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Member Since</p>
                    <p class="font-grotesk font-bold text-lg text-on-surface">
                        {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- No active package --}}
    <div class="md:col-span-8 bg-surface-container-low rounded-[2rem] p-8 flex flex-col items-center justify-center text-center border border-error/20">
        <span class="material-symbols-outlined text-5xl text-error mb-4">card_off</span>
        <h3 class="font-syne font-black text-2xl text-on-surface mb-2">No Active Membership</h3>
        <p class="text-on-surface-variant text-sm max-w-xs">You don't have an active membership plan. Contact your gym admin to get enrolled.</p>
    </div>
    @endif

    {{-- ── STREAK CARD (col 4) ── --}}
    <div class="md:col-span-4 bg-surface-container-low rounded-[2rem] p-8 flex flex-col justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-1">Workout Streak</p>
            <div class="flex items-end gap-3 mt-2">
                <span class="font-syne font-black text-7xl text-secondary leading-none">{{ $streak }}</span>
                <span class="text-on-surface-variant text-sm mb-2 font-medium">days</span>
            </div>
            @if($streak > 0)
                <span class="inline-block mt-3 px-3 py-1 bg-secondary/10 border border-secondary/30 text-secondary text-[10px] font-black uppercase tracking-widest rounded-full">
                    Keep it up!
                </span>
            @else
                <span class="inline-block mt-3 px-3 py-1 bg-surface-container-highest text-on-surface-variant text-[10px] font-bold uppercase tracking-widest rounded-full">
                    Start Today
                </span>
            @endif
        </div>

        <div class="mt-8">
            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-3">Total Sessions</p>
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined ms-fill text-primary-container text-3xl">fitness_center</span>
                <span class="font-grotesk font-black text-3xl text-on-surface">{{ $totalSessions }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── BENTO GRID ROW 2 ── --}}
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">

    {{-- ── ATTENDANCE LAST 30 DAYS (col 8) ── --}}
    <div class="md:col-span-8 bg-surface-container-low rounded-[2rem] p-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-syne font-black text-2xl text-on-surface tracking-tight">CONSISTENCY</h3>
                <p class="text-on-surface-variant text-sm mt-1">Your check-ins over the last 30 days</p>
            </div>
            <div class="text-right">
                <p class="font-syne font-black text-4xl text-primary-container leading-none">
                    {{ $attendanceLast30->count() }}
                </p>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mt-1">sessions</p>
            </div>
        </div>

        {{-- Dot-grid calendar (last 30 days) --}}
        @php
            $dotDays = collect();
            for ($i = 29; $i >= 0; $i--) {
                $d = now()->subDays($i)->toDateString();
                $dotDays->push($d);
            }
            $attendedDays = $attendanceLast30->map(fn($a) => $a->checked_in_at->toDateString())->unique()->flip();
        @endphp
        <div class="grid gap-2" style="grid-template-columns: repeat(10, minmax(0, 1fr));">
            @foreach($dotDays as $day)
                @php
                    $attended = isset($attendedDays[$day]);
                    $isToday  = $day === now()->toDateString();
                @endphp
                <div class="relative group aspect-square rounded-lg flex items-center justify-center cursor-default
                    {{ $attended
                        ? 'bg-primary-container shadow-[0_0_10px_rgba(200,241,53,0.25)]'
                        : 'bg-surface-container-highest' }}
                    {{ $isToday ? 'ring-2 ring-white/50' : '' }}"
                     title="{{ \Carbon\Carbon::parse($day)->format('M d') }}{{ $attended ? ' · Checked in' : '' }}">
                    <span class="text-[9px] font-bold {{ $attended ? 'text-on-primary' : 'text-on-surface-variant/40' }}">
                        {{ \Carbon\Carbon::parse($day)->format('d') }}
                    </span>
                    {{-- Tooltip on hover --}}
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-highest text-[9px] text-on-surface px-2 py-1 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                        {{ \Carbon\Carbon::parse($day)->format('M d') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center gap-6 mt-6 text-[10px] text-on-surface-variant">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded bg-primary-container inline-block"></span>
                Checked in
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded bg-surface-container-highest inline-block"></span>
                No session
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded ring-2 ring-white/50 bg-surface-container-highest inline-block"></span>
                Today
            </span>
        </div>
    </div>

    {{-- ── NOTICES (col 4) ── --}}
    <div class="md:col-span-4 bg-surface-container-low rounded-[2rem] p-8 flex flex-col">
        <h3 class="font-syne font-black text-xl text-on-surface tracking-tight mb-6">NOTICES</h3>

        @if($notices->isNotEmpty())
            <div class="space-y-5 flex-1">
                @foreach($notices as $notice)
                <div class="relative pl-4" style="border-left: 2px solid {{ $loop->first ? '#c8f135' : '#444934' }};">
                    <span class="text-[10px] font-bold uppercase tracking-widest
                        {{ $loop->first ? 'text-primary-container' : 'text-on-surface-variant' }}">
                        {{ $notice->type ?? 'General' }}
                    </span>
                    <p class="text-on-surface font-bold text-sm mt-0.5">{{ $notice->title }}</p>
                    <p class="text-on-surface-variant text-xs mt-1 leading-relaxed line-clamp-2">
                        {{ $notice->message }}
                    </p>
                    @if($notice->sent_at)
                        <p class="text-[10px] text-on-surface-variant/50 mt-1.5">{{ $notice->sent_at->diffForHumans() }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center py-6">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 mb-3">campaign</span>
                <p class="text-on-surface-variant text-sm">No notices right now.</p>
            </div>
        @endif
    </div>
</div>

{{-- ── ROW 3: PAYMENTS ── --}}
<div class="bg-surface-container-low rounded-[2rem] p-8">
    <div class="flex items-center justify-between mb-8">
        <h3 class="font-syne font-black text-xl text-on-surface tracking-tight">PAYMENT HISTORY</h3>
        <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Last 5 transactions</span>
    </div>

    @if($payments->isNotEmpty())
        <div class="space-y-3">
            @foreach($payments as $pay)
            @php
                $statusColor = match($pay->status) {
                    'active'  => ['bg' => 'bg-secondary/10', 'text' => 'text-secondary', 'border' => 'border-secondary/20'],
                    'expired' => ['bg' => 'bg-error/10',     'text' => 'text-error',     'border' => 'border-error/20'],
                    'frozen'  => ['bg' => 'bg-outline/10',   'text' => 'text-outline',   'border' => 'border-outline/20'],
                    default   => ['bg' => 'bg-surface-container-highest', 'text' => 'text-on-surface-variant', 'border' => 'border-outline-variant/20'],
                };
            @endphp
            <div class="flex items-center justify-between px-6 py-4 bg-surface-container rounded-2xl hover:bg-surface-container-high transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary-container/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary-container text-xl">receipt_long</span>
                    </div>
                    <div>
                        <p class="text-on-surface font-bold text-sm">{{ $pay->gymPackage->name ?? 'Package' }}</p>
                        <p class="text-on-surface-variant text-xs mt-0.5">
                            {{ $pay->start_date->format('M d, Y') }} → {{ $pay->end_date->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                <div class="text-right flex items-center gap-4">
                    <p class="font-grotesk font-black text-on-surface text-base">Rs. {{ number_format($pay->amount_paid, 0) }}</p>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border
                        {{ $statusColor['bg'] }} {{ $statusColor['text'] }} {{ $statusColor['border'] }}">
                        {{ $pay->status }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/20 mb-3">payments</span>
            <p class="text-on-surface-variant text-sm">No payment records found.</p>
        </div>
    @endif
</div>

@endsection
