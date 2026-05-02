@extends('layouts.member')

@section('title', 'My Profile')
@section('topbar-title', 'My Profile')

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="mb-10">
    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-primary-container mb-2">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
    <h1 class="font-syne font-black text-5xl md:text-6xl text-on-surface tracking-tighter leading-none uppercase">
        {{ explode(' ', $user->name)[0] }}
        <span class="text-primary-container">{{ implode(' ', array_slice(explode(' ', $user->name), 1)) ?: '' }}</span>
    </h1>
    <p class="text-on-surface-variant mt-2 text-base flex items-center gap-2">
        <span class="material-symbols-outlined ms-fill text-secondary text-lg">verified</span>
        {{ $user->tenant?->name ?? 'Gym Member' }}
        @if($package)
            &nbsp;·&nbsp;
            <span class="text-primary-container font-bold">{{ $package->gymPackage->name }}</span>
        @endif
    </p>
</div>

{{-- ── BENTO GRID ── --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- ── LEFT: PHOTO + LEDGER (col 4) ── --}}
    <div class="lg:col-span-4 space-y-6">

        {{-- Profile photo card --}}
        <div class="relative rounded-[2rem] overflow-hidden aspect-square bg-surface-container-high group">
            @if($user->profile_picture)
                <img src="{{ asset(Storage::url($user->profile_picture)) }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                     alt="{{ $user->name }}">
            @else
                <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                    <span class="font-syne font-black text-9xl text-primary-container/30 select-none">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
            @endif

            {{-- gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

            {{-- Camera button --}}
            <label for="photo-upload"
                   class="absolute bottom-5 right-5 w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-on-primary cursor-pointer shadow-xl hover:scale-110 active:scale-95 transition-all">
                <span class="material-symbols-outlined ms-fill text-lg">photo_camera</span>
            </label>

            {{-- Name overlay --}}
            <div class="absolute bottom-5 left-5">
                @if($package)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-secondary/20 backdrop-blur border border-secondary/30 text-secondary text-[10px] font-black uppercase tracking-widest rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary inline-block"></span>
                        Active Member
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-error/20 backdrop-blur border border-error/30 text-error text-[10px] font-black uppercase tracking-widest rounded-full">
                        No Active Plan
                    </span>
                @endif
            </div>
        </div>

        {{-- Payment ledger card --}}
        <div class="bg-surface-container-high rounded-[2rem] p-7">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-syne font-black text-lg text-on-surface">Ledger</h3>
                <a href="{{ route('member.membership') }}" class="text-secondary text-[10px] font-black uppercase tracking-widest hover:underline">
                    Full History
                </a>
            </div>

            @if($payments->isNotEmpty())
                <div class="space-y-5">
                    @foreach($payments as $pay)
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface font-bold text-sm">{{ $pay->gymPackage->name ?? 'Package' }}</p>
                            <p class="text-on-surface-variant text-xs mt-0.5">{{ $pay->start_date->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-on-surface font-grotesk font-bold text-sm">Rs. {{ number_format($pay->amount_paid, 0) }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase
                                {{ $pay->status === 'active' ? 'bg-secondary/10 text-secondary' : 'bg-error/10 text-error' }}">
                                {{ $pay->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-on-surface-variant text-sm text-center py-6">No payment records.</p>
            @endif
        </div>
    </div>

    {{-- ── RIGHT: PERSONAL INFO + EDIT FORM (col 8) ── --}}
    <div class="lg:col-span-8 space-y-6">

        {{-- Personal ecosystem card --}}
        <div class="bg-surface-container-high/50 backdrop-blur-md rounded-[2rem] p-8"
             style="border-left: 4px solid #c8f135;">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-syne font-black text-2xl text-on-surface">Personal Ecosystem</h2>
                <button onclick="toggleEdit()"
                        id="edit-toggle-btn"
                        class="flex items-center gap-2 px-4 py-2 bg-surface-container-highest rounded-xl text-on-surface-variant hover:text-on-surface text-sm font-bold transition-colors">
                    <span class="material-symbols-outlined text-base" id="edit-icon">edit</span>
                    <span id="edit-label">Edit</span>
                </button>
            </div>

            {{-- ── VIEW MODE ── --}}
            <div id="view-mode">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-12">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-1">Full Name</p>
                        <p class="text-xl font-medium text-on-surface">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-1">Email Address</p>
                        <p class="text-xl font-medium text-on-surface">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-1">Phone</p>
                        <p class="text-xl font-medium text-on-surface">{{ $user->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-1">Date of Birth</p>
                        <p class="text-xl font-medium text-on-surface">
                            {{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-1">Gender</p>
                        <p class="text-xl font-medium text-on-surface capitalize">{{ $user->gender ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-1">Home Base</p>
                        <p class="text-xl font-medium text-on-surface">{{ $user->address ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-8" style="border-top: 1px solid rgba(68,73,52,0.3)">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-secondary mb-6">Emergency Protocol</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div>
                            <p class="text-on-surface-variant text-xs mb-1">Emergency Contact</p>
                            <p class="text-lg font-bold text-on-surface">{{ $user->emergency_contact ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-on-surface-variant text-xs mb-1">Blood Group</p>
                            <p class="text-lg font-bold text-on-surface">{{ $user->blood_group ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── EDIT MODE ── --}}
            <div id="edit-mode" class="hidden">
                <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- hidden file input for profile photo --}}
                    <input type="file" id="photo-upload" name="profile_picture" class="hidden" accept="image/*"
                           onchange="this.form.submit()">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                            @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                   class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Gender</label>
                            <select name="gender" class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                                <option value="">— Select —</option>
                                <option value="male"   {{ old('gender', $user->gender) === 'male'   ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other"  {{ old('gender', $user->gender) === 'other'  ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Home Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                   class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                        </div>
                    </div>

                    <div style="border-top: 1px solid rgba(68,73,52,0.3)" class="pt-6 mb-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-secondary mb-5">Emergency Protocol</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Emergency Contact</label>
                                <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $user->emergency_contact) }}"
                                       class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 mb-2 block">Blood Group</label>
                                <select name="blood_group" class="w-full bg-surface-container-lowest rounded-xl px-4 py-3 text-on-surface text-sm border-0 focus:ring-2 focus:ring-primary-container outline-none">
                                    <option value="">— Select —</option>
                                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                        <option value="{{ $bg }}" {{ old('blood_group', $user->blood_group) === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                                class="kinetic-gradient text-on-primary font-syne font-black text-sm uppercase tracking-wider px-8 py-4 rounded-2xl hover:scale-[1.02] active:scale-95 transition-all shadow-lg shadow-primary-container/20">
                            Save Changes
                        </button>
                        <button type="button" onclick="toggleEdit()"
                                class="px-8 py-4 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:text-on-surface text-sm font-bold transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Membership status mini-card --}}
        @if($package)
        @php
            $daysLeft  = max(0, now()->diffInDays($package->end_date, false));
            $totalDays = max(1, $package->start_date->diffInDays($package->end_date));
            $pct       = round(($totalDays - $daysLeft) / $totalDays * 100);
        @endphp
        <div class="bg-surface-container-low rounded-[2rem] p-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-center overflow-hidden relative">
            <div class="z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-black uppercase tracking-widest mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary inline-block animate-pulse"></span>
                    Active Plan
                </span>
                <h3 class="font-syne font-black text-3xl text-on-surface leading-none mb-2 uppercase">
                    {{ $package->gymPackage->name }}
                </h3>
                <p class="text-on-surface-variant text-sm mb-6">{{ $package->gymPackage->description ?? $package->gymPackage->duration_text . ' membership' }}</p>

                <div class="space-y-2">
                    <div class="flex justify-between text-[10px] text-on-surface-variant">
                        <span>Renewal in {{ $daysLeft }} days</span>
                        <span class="font-bold text-on-surface">{{ $pct }}% complete</span>
                    </div>
                    <div class="w-full h-2 bg-surface-container-highest rounded-full overflow-hidden">
                        <div class="h-full bg-secondary rounded-full shadow-[0_0_10px_rgba(68,250,164,0.3)]"
                             style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">Amount Paid</p>
                <p class="font-grotesk font-black text-4xl text-primary-container">Rs. {{ number_format($package->amount_paid, 0) }}</p>
                <p class="text-on-surface-variant text-xs mt-2">{{ $package->start_date->format('M d') }} → {{ $package->end_date->format('M d, Y') }}</p>
                <a href="{{ route('member.membership') }}"
                   class="inline-block mt-5 px-6 py-3 bg-surface-container-highest hover:bg-surface-bright text-on-surface font-bold text-sm rounded-xl transition-colors">
                    View Plans
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    let editing = false;

    // Auto-open edit if there are validation errors
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => { toggleEdit(); });
    @endif

    function toggleEdit() {
        editing = !editing;
        document.getElementById('view-mode').classList.toggle('hidden', editing);
        document.getElementById('edit-mode').classList.toggle('hidden', !editing);
        document.getElementById('edit-icon').textContent  = editing ? 'close' : 'edit';
        document.getElementById('edit-label').textContent = editing ? 'Cancel' : 'Edit';
    }
</script>
@endsection
