<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $packages = $tenant->gymPackages()
            ->orderBy('sort_order')
            ->paginate(20);

        return view('gym.packages.index', compact('packages'));
    }

    public function create(Request $request): View
    {
        return view('gym.packages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_type' => 'required|in:days,months,years',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'max_members' => 'nullable|integer',
            'features' => 'nullable|array',
        ]);

        $tenant->gymPackages()->create($validated);

        return redirect()->route('gym.packages.index')
            ->with('success', 'Package created successfully!');
    }

    public function show(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $package = $tenant->gymPackages()->findOrFail($id);

        return view('gym.packages.show', compact('package'));
    }

    public function edit(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $package = $tenant->gymPackages()->findOrFail($id);

        return view('gym.packages.edit', compact('package'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $package = $tenant->gymPackages()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_type' => 'required|in:days,months,years',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'max_members' => 'nullable|integer',
            'features' => 'nullable|array',
        ]);

        $package->update($validated);

        return redirect()->route('gym.packages.show', $package->id)
            ->with('success', 'Package updated successfully!');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $package = $tenant->gymPackages()->findOrFail($id);

        $package->delete();

        return redirect()->route('gym.packages.index')
            ->with('success', 'Package deleted successfully!');
    }
}
