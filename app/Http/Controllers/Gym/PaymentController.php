<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Models\MemberPackage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $payments = MemberPackage::where('tenant_id', $tenant->id)
            ->with(['user', 'gymPackage'])
            ->latest()
            ->paginate(20);

        return view('gym.payments.index', compact('payments'));
    }

    public function create(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $members = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->get();

        $packages = $tenant->gymPackages()->active()->get();

        return view('gym.payments.create', compact('members', 'packages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gym_package_id' => 'required|exists:gym_packages,id',
            'amount_paid' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'payment_method' => 'nullable|string',
        ]);

        $tenant = $request->user()->tenant;
        $package = $tenant->gymPackages()->findOrFail($validated['gym_package_id']);

        $endDate = $validated['start_date'];
        if ($package->duration_type === 'months') {
            $endDate = date('Y-m-d', strtotime($validated['start_date'].' +'.$package->duration_days.' months'));
        } elseif ($package->duration_type === 'years') {
            $endDate = date('Y-m-d', strtotime($validated['start_date'].' +'.$package->duration_days.' years'));
        } else {
            $endDate = date('Y-m-d', strtotime($validated['start_date'].' +'.$package->duration_days.' days'));
        }

        MemberPackage::create([
            'tenant_id' => $tenant->id,
            'user_id' => $validated['user_id'],
            'gym_package_id' => $validated['gym_package_id'],
            'amount_paid' => $validated['amount_paid'],
            'start_date' => $validated['start_date'],
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        return redirect()->route('gym.payments.index')
            ->with('success', 'Payment recorded successfully!');
    }

    public function show(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $payment = MemberPackage::where('tenant_id', $tenant->id)
            ->with(['user', 'gymPackage'])
            ->findOrFail($id);

        return view('gym.payments.show', compact('payment'));
    }

    public function receipt(Request $request, string $payment): View
    {
        $tenant = $request->user()->tenant;

        $memberPackage = MemberPackage::where('tenant_id', $tenant->id)
            ->with(['user', 'gymPackage'])
            ->findOrFail($payment);

        $issuedBy = $request->user();

        return view('gym.payments.receipt', [
            'tenant' => $tenant,
            'payment' => $memberPackage,
            'issuedBy' => $issuedBy,
        ]);
    }

    public function edit(Request $request, string $id): View
    {
        $tenant = $request->user()->tenant;

        $payment = MemberPackage::where('tenant_id', $tenant->id)
            ->with(['user', 'gymPackage'])
            ->findOrFail($id);

        $members = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->get();

        $packages = $tenant->gymPackages()->active()->get();

        return view('gym.payments.edit', compact('payment', 'members', 'packages'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $payment = MemberPackage::where('tenant_id', $tenant->id)->findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gym_package_id' => 'required|exists:gym_packages,id',
            'amount_paid' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_method' => 'nullable|string',
            'status' => 'required|in:active,expired,frozen',
        ]);

        $package = $tenant->gymPackages()->findOrFail($validated['gym_package_id']);

        if ($validated['gym_package_id'] !== (string) $payment->gym_package_id) {
            if ($package->duration_type === 'months') {
                $endDate = date('Y-m-d', strtotime($validated['start_date'].' +'.$package->duration_days.' months'));
            } elseif ($package->duration_type === 'years') {
                $endDate = date('Y-m-d', strtotime($validated['start_date'].' +'.$package->duration_days.' years'));
            } else {
                $endDate = date('Y-m-d', strtotime($validated['start_date'].' +'.$package->duration_days.' days'));
            }
            $validated['end_date'] = $endDate;
        }

        $payment->update($validated);

        return redirect()->route('gym.payments.show', $payment->id)
            ->with('success', 'Payment updated successfully!');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $payment = MemberPackage::where('tenant_id', $tenant->id)->findOrFail($id);

        $payment->delete();

        return redirect()->route('gym.payments.index')
            ->with('success', 'Payment deleted successfully!');
    }
}
