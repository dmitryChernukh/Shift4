<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AciService implements PaymentServiceInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    final public function makePurchase(array $params): array
    {
        $response = $this->client->request('POST', 'https://test.oppwa.com/v1/payments', [
            'json' => $params,
        ]);

        return $response->toArray();
    }
}
