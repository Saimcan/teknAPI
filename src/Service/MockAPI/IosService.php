<?php

namespace App\Service\MockAPI;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class IosService extends MockBaseService
{

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function purchase(array $payload): string
    {
        $mockHttpClient = parent::process($payload, 'https://api.apple.com');

        $response = $mockHttpClient->request('POST', 'purchase/'.$payload['receipt'], [
            'headers' => [
                'Accept: */*',
                'Authorization: Basic YWxhZGRpbjpvcGVuc2VzYW1l',
            ],
        ]);

        return $response->getContent();
    }
}