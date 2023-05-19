<?php

namespace App\Service\MockAPI;

use DateInterval;
use DateTimeZone;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class MockBaseService implements MockInterface
{
    public function process(array $payload, string $baseUri): MockHttpClient
    {
        $now = new \DateTime();
        $timeZone = new DateTimeZone('America/Chicago');
        $now->setTimezone($timeZone);

        $receipt = $payload['receipt'];
        $lastDigit = (int)substr($receipt, -1);

        $status = false;
        $httpCode = Response::HTTP_OK;
        if($lastDigit & 1){
            //odd
            $status = true;
        }

        $mockResponse = new MockResponse(json_encode([
            'status' => $status,
            'expire-date' => $now->add(new DateInterval('P90D'))->format('Y-m-d H:i:s'),
        ]), [
            'http_code' => $httpCode
        ]);

        return new MockHttpClient($mockResponse, $baseUri);
    }
}