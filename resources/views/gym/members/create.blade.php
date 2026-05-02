@extends('layouts.gym')

@section('title', 'Add Member')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.members.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Members
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Form Section -->
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
        <h2 class="text-2xl font-headline font-bold text-white mb-8">Add New Member</h2>

        <form method="POST" action="{{ route('gym.members.store') }}" class="space-y-6" enctype="multipart/form-data" id="memberForm">
            @csrf
            @if($errors->any())
            <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Full Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Phone Number *</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="9800000000">
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Email (Optional)</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="member@example.com">
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Portal Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" value="{{ old('password') }}"
                    class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 pr-12 text-white focus:outline-none focus:border-primary-lime transition-all"
                    placeholder="Leave blank = phone number">
                <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-on-variant hover:text-white transition-colors">
                    <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
            </div>
            <p class="text-xs text-on-variant mt-2">If left blank, the member's phone number will be used as the login password.</p>
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-on-variant mb-2">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
            <div>
                <label class="block text-sm text-on-variant mb-2">Gender</label>
                <select name="gender" id="gender" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                    <option value="">Select</option>
                    <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other"  {{ old('gender') == 'other'  ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Emergency Contact</label>
            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact') }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/*" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-lime file:text-black hover:file:bg-opacity-80" id="profile_picture">
        </div>

        <div>
            <label class="block text-sm text-on-variant mb-2">Blood Group</label>
            <select name="blood_group" id="blood_group" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                <option value="">Select Blood Group</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
            Add Member
        </button>
        </form>
    </div>

    <!-- Live Preview Section -->
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 sticky top-8">
        <h3 class="text-xl font-headline font-bold text-white mb-6">Live Preview</h3>

        <div class="space-y-6">
            <!-- Profile Picture Preview -->
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 bg-black/20 border-2 border-dashed border-primary-border rounded-full flex items-center justify-center mb-4" id="profilePicturePreview">
                    <svg class="w-8 h-8 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <p class="text-sm text-on-variant">Profile Picture</p>
            </div>

            <!-- Member Details Preview -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-on-variant mb-1">Full Name</label>
                    <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewName">-</div>
                </div>

                <div>
                    <label class="block text-sm text-on-variant mb-1">Phone Number</label>
                    <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewPhone">-</div>
                </div>

                <div>
                    <label class="block text-sm text-on-variant mb-1">Email</label>
                    <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewEmail">-</div>
                </div>

                <div>
                    <label class="block text-sm text-on-variant mb-1">Address</label>
                    <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewAddress">-</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-on-variant mb-1">Date of Birth</label>
                        <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewDob">-</div>
                    </div>
                    <div>
                        <label class="block text-sm text-on-variant mb-1">Gender</label>
                        <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewGender">-</div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-on-variant mb-1">Emergency Contact</label>
                    <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewEmergency">-</div>
                </div>

                <div>
                    <label class="block text-sm text-on-variant mb-1">Blood Group</label>
                    <div class="bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white min-h-[48px] flex items-center" id="previewBloodGroup">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const eye   = document.getElementById('eye-' + fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

// Live preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('memberForm');
    const inputs = form.querySelectorAll('input, select');

    function updatePreview() {
        const getVal = (id) => document.getElementById(id)?.value || '-';
        const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };

        setText('previewName', getVal('name'));
        setText('previewPhone', getVal('phone'));
        setText('previewEmail', getVal('email'));
        setText('previewAddress', getVal('address'));
        setText('previewDob', getVal('date_of_birth'));
        setText('previewGender', getVal('gender'));
        setText('previewEmergency', getVal('emergency_contact'));
        setText('previewBloodGroup', getVal('blood_group'));

        const profilePictureInput = document.getElementById('profile_picture');
        const previewContainer = document.getElementById('profilePicturePreview');

        if (profilePictureInput?.files?.[0] && previewContainer) {
            const file = profilePictureInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" class="w-24 h-24 rounded-full object-cover" alt="Profile Preview">`;
            };

            reader.readAsDataURL(file);
        } else if (previewContainer) {
            previewContainer.innerHTML = `
                <svg class="w-8 h-8 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            `;
        }
    }

    // Add event listeners to all form inputs
    inputs.forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Initial preview update
    updatePreview();
});
</script>
@endsection
