<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\JsonResponse;

class APIResponseFactory
{
    public const REGISTRATION_SUCCESS = 10;
    public const REGISTRATION_FAILED = 11;
    public const SUBSCRIPTION_PRESENT = 20;
    public const SUBSCRIPTION_NOT_PRESENT = 21;
    private int $code;
    private string $message;
    private string $status;
    private array $responseArray;
    public function __construct(int $code, string $message, string $status)
    {
        $this->code = $code;
        $this->message = $message;
        $this->status = $status;
        $this->responseArray = [
            "code" => $this->code,
            "message" => $this->message,
            "status" => $this->status
        ];
    }

    public function generateJsonResponse(int $clientResponse): JsonResponse
    {
        return new JsonResponse(
            json_encode($this->responseArray),
            $clientResponse,
            [],
            true
        );
    }
}