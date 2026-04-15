<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $staff = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->whereIn('slug', ['trainer', 'staff', 'admin']))
            ->with('role')
            ->latest()
            ->paginate(20);

        return view('gym.staff.index', compact('staff'));
    }

    public function create(Request $request): View
    {
        $tenant = $request->user()->tenant;
        $roles = Role::where('tenant_id', $tenant->id)
            ->whereIn('slug', ['trainer', 'staff'])
            ->get();

        return view('gym.staff.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'role_id' => 'required|exists:roles,id',
            'specialization' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'join_date' => 'nullable|date',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? $validated['phone'].'@gymsathi.com',
            'password' => bcrypt($validated['phone']),
            'tenant_id' => $tenant->id,
            'role_id' => $validated['role_id'],
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'] ?? null,
            'salary' => $validated['salary'] ?? null,
            'join_date' => $validated['join_date'] ?? null,
        ]);

        return redirect()->route('gym.staff.index')
            ->with('success', 'Staff member added successfully!');
    }

    public function show(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $staff = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->whereIn('slug', ['trainer', 'staff', 'admin']))
            ->with('role')
            ->findOrFail($id);

        return view('gym.staff.show', compact('staff'));
    }

    public function edit(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $staff = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->whereIn('slug', ['trainer', 'staff', 'admin']))
            ->findOrFail($id);

        $roles = Role::where('tenant_id', $tenant->id)
            ->whereIn('slug', ['trainer', 'staff'])
            ->get();

        return view('gym.staff.edit', compact('staff', 'roles'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $staff = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->whereIn('slug', ['trainer', 'staff', 'admin']))
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'role_id' => 'required|exists:roles,id',
        ]);

        $staff->update($validated);

        return redirect()->route('gym.staff.show', $staff->id)
            ->with('success', 'Staff updated successfully!');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $staff = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->whereIn('slug', ['trainer', 'staff', 'admin']))
            ->findOrFail($id);

        $staff->delete();

        return redirect()->route('gym.staff.index')
            ->with('success', 'Staff deleted successfully!');
    }
}
