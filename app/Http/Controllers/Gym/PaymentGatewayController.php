<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Models\MemberPackage;
use App\Models\Payment;
use App\Models\User;
use App\Services\EsewaGateway;
use App\Services\KhaltiGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentGatewayController extends Controller
{
    protected array $gateways = [];

    public function __construct()
    {
        $this->gateways = [
            'esewa' => new EsewaGateway,
            'khalti' => new KhaltiGateway,
        ];
    }

    public function initiate(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'gateway' => 'required|in:esewa,khalti',
            'package_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
        ]);

        $gateway = $this->gateways[$request->gateway] ?? null;

        if (! $gateway || ! $gateway->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment gateway is not configured',
            ], 400);
        }

        $user = $request->user();
        $packageId = $request->package_id;
        $amount = $request->amount;

        $productName = 'Gym Membership';
        $productId = 'GYM-PKG-'.$packageId.'-USR-'.$user->id.'-'.time();

        $result = $gateway->initiate([
            'amount' => $amount,
            'product_id' => $productId,
            'product_name' => $productName,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?? '9800000000',
        ]);

        if (! $result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to initiate payment',
            ], 400);
        }

        Session::put('pending_payment', [
            'gateway' => $request->gateway,
            'transaction_id' => $result['transaction_id'],
            'package_id' => $packageId,
            'user_id' => $user->id,
            'amount' => $amount,
            'created_at' => now()->toIso8601String(),
        ]);

        return response()->json([
            'success' => true,
            'payment_url' => $result['payment_url'],
            'transaction_id' => $result['transaction_id'],
        ]);
    }

    public function callback(Request $request, string $gateway): RedirectResponse
    {
        $gatewayObj = $this->gateways[$gateway] ?? null;

        if (! $gatewayObj) {
            return redirect()->route('member.membership')
                ->with('error', 'Invalid payment gateway');
        }

        $result = $gatewayObj->handleCallback($request);

        if (! $result->isSuccessful()) {
            Log::warning("Payment callback failed for {$gateway}: ".$result->getMessage());

            return redirect()->route('member.membership')
                ->with('error', 'Payment verification failed: '.$result->getMessage());
        }

        $pending = Session::get('pending_payment');

        if (! $pending || $pending['gateway'] !== $gateway) {
            return redirect()->route('member.membership')
                ->with('error', 'No pending payment found');
        }

        try {
            $memberPackage = MemberPackage::find($pending['package_id']);

            if ($memberPackage) {
                $memberPackage->update([
                    'status' => 'active',
                    'amount_paid' => $pending['amount'],
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addDays($memberPackage->gymPackage?->duration_days ?? 30)->toDateString(),
                ]);
            }

            $user = User::find($pending['user_id']);
            if ($user) {
                Payment::create([
                    'tenant_id' => $user->tenant_id,
                    'reference_id' => $result->getTransactionId(),
                    'method' => $gateway,
                    'status' => 'completed',
                    'amount' => $result->getAmount(),
                    'payment_date' => now()->toDateString(),
                    'metadata' => $result->getRawData(),
                ]);
            }

            Log::info("Payment completed: {$gateway} - {$result->getTransactionId()}");

            Session::forget('pending_payment');

            return redirect()->route('member.membership')
                ->with('success', 'Payment successful! Your membership is now active.');
        } catch (\Exception $e) {
            Log::error('Payment callback error: '.$e->getMessage());

            return redirect()->route('member.membership')
                ->with('error', 'Payment processed but error occurred: '.$e->getMessage());
        }
    }

    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'gateway' => 'required|in:esewa,khalti',
            'transaction_id' => 'required|string',
        ]);

        $gateway = $this->gateways[$request->gateway] ?? null;

        if (! $gateway) {
            return response()->json(['success' => false, 'message' => 'Invalid gateway']);
        }

        $result = $gateway->verify(['pidx' => $request->transaction_id]);

        return response()->json([
            'success' => $result->isSuccessful(),
            'message' => $result->getMessage(),
            'data' => $result->getRawData(),
        ]);
    }

    public function status(Request $request): JsonResponse
    {
        $pending = Session::get('pending_payment');

        return response()->json([
            'has_pending' => (bool) $pending,
            'pending' => $pending,
        ]);
    }
}
