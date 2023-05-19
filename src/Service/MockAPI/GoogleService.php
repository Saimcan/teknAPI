<?php

namespace App\Service\MockAPI;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GoogleService extends MockBaseService
{

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function purchase(array $payload): string
    {
        $mockHttpClient = parent::process($payload, 'https://api.google.com');

        $response = $mockHttpClient->request('POST', 'purchase/'.$payload['receipt'], [
            'headers' => [
                'Accept: */*',
                'Authorization: Basic YWxhZGRpbjpvcGVuc2VzYW1l',
            ],
        ]);

        return $response->getContent();
    }
}