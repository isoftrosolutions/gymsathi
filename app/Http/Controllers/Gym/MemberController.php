<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $members = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->with(['memberPackages.gymPackage', 'role'])
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
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $memberRole = Role::where('tenant_id', $tenant->id)
            ->where('slug', 'member')
            ->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? $validated['phone'].'@gymsathi.com',
            'password' => bcrypt($validated['phone']),
            'tenant_id' => $tenant->id,
            'role_id' => $memberRole?->id,
        ]);

        return redirect()->route('gym.members.index')
            ->with('success', 'Member added successfully!');
    }

    public function show(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $member = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->with(['memberPackages.gymPackage', 'role'])
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
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

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
