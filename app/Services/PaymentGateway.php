<?php

namespace App\Services;

use Illuminate\Http\Request;

interface PaymentGateway
{
    public function initiate(array $data): array;

    public function verify(array $data): PaymentResult;

    public function handleCallback(Request $request): PaymentResult;

    public function getGatewayName(): string;

    public function isConfigured(): bool;
}

interface PaymentResult
{
    public function isSuccessful(): bool;

    public function getTransactionId(): ?string;

    public function getAmount(): ?float;

    public function getMessage(): string;

    public function getRawData(): array;
}
