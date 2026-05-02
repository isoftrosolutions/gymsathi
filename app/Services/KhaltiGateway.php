<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KhaltiGateway implements PaymentGateway
{
    protected string $apiKey;

    protected string $baseUrl;

    protected string $callbackUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.khalti.base_url', 'https://khalti.com/api/v2');
        $this->apiKey = config('services.khalti.api_key', '');
        $this->callbackUrl = config('services.khalti.callback_url', url('/payment/khalti/callback'));
    }

    public function getGatewayName(): string
    {
        return 'khalti';
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    public function initiate(array $data): array
    {
        $amount = $data['amount'];
        $productIdentity = $data['product_id'] ?? 'GYM-'.uniqid();
        $productName = $data['product_name'] ?? 'Gym Membership';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl.'/epayment/initiate/', [
                'return_url' => $this->callbackUrl,
                'website_url' => url('/'),
                'amount' => $amount * 100,
                'purchase_order_id' => $productIdentity,
                'purchase_order_name' => $productName,
                'customer_info' => [
                    'name' => $data['customer_name'] ?? 'Gym Member',
                    'email' => $data['customer_email'] ?? 'member@example.com',
                    'phone' => $data['customer_phone'] ?? '9800000000',
                ],
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                return [
                    'success' => true,
                    'payment_url' => $responseData['payment_url'],
                    'pidx' => $responseData['pidx'],
                    'transaction_id' => $productIdentity,
                    'amount' => $amount,
                ];
            }

            Log::error('Khalti initiate error: '.$response->body());

            return [
                'success' => false,
                'message' => 'Failed to initiate payment',
            ];
        } catch (\Exception $e) {
            Log::error('Khalti initiate exception: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Payment initiation failed: '.$e->getMessage(),
            ];
        }
    }

    public function verify(array $data): PaymentResult
    {
        $pidx = $data['pidx'] ?? null;

        if (! $pidx) {
            return new KhaltiPaymentResult(false, null, null, 'Missing payment index');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl.'/epayment/lookup/', [
                'pidx' => $pidx,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['status'] === 'Completed') {
                    $amount = ($responseData['amount'] ?? 0) / 100;

                    return new KhaltiPaymentResult(
                        true,
                        $pidx,
                        $amount,
                        'Payment verified successfully',
                        $responseData
                    );
                }

                return new KhaltiPaymentResult(
                    false,
                    $pidx,
                    ($responseData['amount'] ?? 0) / 100,
                    'Payment status: '.($responseData['status'] ?? 'unknown')
                );
            }

            return new KhaltiPaymentResult(false, $pidx, null, 'Verification failed');
        } catch (\Exception $e) {
            Log::error('Khalti verification error: '.$e->getMessage());

            return new KhaltiPaymentResult(false, null, null, 'Verification failed: '.$e->getMessage());
        }
    }

    public function handleCallback(Request $request): PaymentResult
    {
        $pidx = $request->get('pidx');

        return $this->verify(['pidx' => $pidx]);
    }
}

class KhaltiPaymentResult implements PaymentResult
{
    protected bool $success;

    protected ?string $transactionId;

    protected ?float $amount;

    protected string $message;

    protected array $rawData;

    public function __construct(bool $success, ?string $transactionId, ?float $amount, string $message, array $rawData = [])
    {
        $this->success = $success;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->message = $message;
        $this->rawData = $rawData;
    }

    public function isSuccessful(): bool
    {
        return $this->success;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }
}
