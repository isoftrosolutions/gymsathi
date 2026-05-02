<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Mail\TemplateMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $members = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->with(['activeMemberPackage.gymPackage', 'role'])
            ->latest()
            ->paginate(20);

        return view('gym.members.index', compact('members'));
    }

    public function create(Request $request): View
    {
        return view('gym.members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $memberRole = Role::where('tenant_id', $tenant->id)
            ->where('slug', 'member')
            ->first();

        // Use provided password, fall back to phone number
        $tempPassword = $validated['password'] ?? $validated['phone'];
        $email = $validated['email'] ?? null;

        // Generate a unique fallback email when none is provided
        $fallbackEmail = $validated['phone'].'@gymsathi.com';
        if (! $email && User::where('email', $fallbackEmail)->exists()) {
            $fallbackEmail = $validated['phone'].'_'.time().'@gymsathi.com';
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $email ?? $fallbackEmail,
            'password' => bcrypt($tempPassword),
            'tenant_id' => $tenant->id,
            'role_id' => $memberRole?->id,
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time().'_'.$user->id.'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $user->update(['profile_picture' => $path]);
        }

        // Send welcome email only if a real email was provided
        if ($email) {
            try {
                Mail::to($email)->send(new TemplateMail('member_registration_success', [
                    'member_name' => $user->name,
                    'gym_name' => $tenant->name,
                    'plan_name' => 'Pending Assignment',
                    'member_email' => $email,
                    'temp_password' => $tempPassword,
                ]));
                Log::info("Member welcome email sent to {$email} (User #{$user->id})");
            } catch (\Exception $e) {
                Log::warning("Member welcome email failed for {$email}: {$e->getMessage()}");
            }
        }

        return redirect()->route('gym.members.index')
            ->with('success', 'Member added successfully!'.($email ? ' Welcome email sent.' : ''));
    }

    public function show(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $member = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->with(['activeMemberPackage.gymPackage', 'memberPackages.gymPackage', 'role'])
            ->findOrFail($id);

        return view('gym.members.show', compact('member'));
    }

    public function edit(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $member = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->findOrFail($id);

        return view('gym.members.edit', compact('member'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $member = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:users,email,'.$member->id,
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($member->profile_picture && Storage::disk('public')->exists($member->profile_picture)) {
                Storage::disk('public')->delete($member->profile_picture);
            }

            $file = $request->file('profile_picture');
            $filename = time().'_'.$member->id.'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $validated['profile_picture'] = $path;
        }

        $member->update($validated);

        return redirect()->route('gym.members.show', $member->id)
            ->with('success', 'Member updated successfully!');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $member = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->findOrFail($id);

        $member->delete();

        return redirect()->route('gym.members.index')
            ->with('success', 'Member deleted successfully!');
    }
}
