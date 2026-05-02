<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EsewaGateway implements PaymentGateway
{
    protected string $baseUrl;

    protected string $merchantId;

    protected string $merchantSecret;

    protected string $callbackUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.esewa.base_url', 'https://esewa.io');
        $this->merchantId = config('services.esewa.merchant_id', '');
        $this->merchantSecret = config('services.esewa.merchant_secret', '');
        $this->callbackUrl = config('services.esewa.callback_url', url('/payment/esewa/callback'));
    }

    public function getGatewayName(): string
    {
        return 'esewa';
    }

    public function isConfigured(): bool
    {
        return ! empty($this->merchantId) && ! empty($this->merchantSecret);
    }

    public function initiate(array $data): array
    {
        $amount = $data['amount'];
        $productId = $data['product_id'] ?? 'GYM-'.uniqid();
        $productName = $data['product_name'] ?? 'Gym Membership';

        $totalAmount = $amount;
        $transactionUuid = $productId;

        $message = base64_encode($this->merchantId.','.$transactionUuid.','.$totalAmount);

        $sha256Hash = hash_hmac('sha256', $message.','.strtolower($this->merchantSecret), $this->merchantSecret);

        $paymentUrl = $this->baseUrl.'/epay/main';

        return [
            'success' => true,
            'payment_url' => $paymentUrl,
            'data' => [
                'oid' => $transactionUuid,
                'amt' => $totalAmount,
                'pid' => $this->merchantId,
                'schl' => $this->callbackUrl,
                'sign' => $sha256Hash,
            ],
            'transaction_id' => $transactionUuid,
            'amount' => $totalAmount,
        ];
    }

    public function verify(array $data): PaymentResult
    {
        $transactionUuid = $data['oid'] ?? null;
        $amount = $data['amt'] ?? null;
        $refId = $data['refId'] ?? null;

        if (! $transactionUuid || ! $amount || ! $refId) {
            return new EsewaPaymentResult(false, null, null, 'Missing required parameters');
        }

        try {
            $verifyUrl = $this->baseUrl.'/epay/vep';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($verifyUrl, [
                'merchant_id' => $this->merchantId,
                'transaction_uuid' => $transactionUuid,
                'amount' => $amount,
                'ref_id' => $refId,
            ]);

            if ($response->successful() && $response->json('status') === 'Complete') {
                return new EsewaPaymentResult(true, $refId, $amount, 'Payment verified successfully', [
                    'oid' => $transactionUuid,
                    'refId' => $refId,
                    'amt' => $amount,
                ]);
            }

            return new EsewaPaymentResult(false, $refId, $amount, 'Payment verification failed');
        } catch (\Exception $e) {
            Log::error('eSewa verification error: '.$e->getMessage());

            return new EsewaPaymentResult(false, null, null, 'Payment verification failed: '.$e->getMessage());
        }
    }

    public function handleCallback(Request $request): PaymentResult
    {
        $data = [
            'oid' => $request->get('oid'),
            'amt' => $request->get('amt'),
            'refId' => $request->get('refId'),
            'fid' => $request->get('fid'),
            'cdl' => $request->get('cdl'),
        ];

        return $this->verify($data);
    }
}

class EsewaPaymentResult implements PaymentResult
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
