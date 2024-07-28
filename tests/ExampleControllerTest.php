<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExampleControllerTest extends WebTestCase
{
    final public function testExampleShift4(): void
    {
        $client = static::createClient();
        $client->request('POST', '/app/example/shift4', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'amount' => 100,
            'currency' => 'USD',
            'card_number' => '4242424242424242',
            'card_exp_month' => 12,
            'card_exp_year' => 2024,
            'card_cvv' => '123',
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    final public function testExampleAci(): void
    {
        $client = static::createClient();
        $client->request('POST', '/app/example/aci', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'amount' => 100,
            'currency' => 'USD',
            'card_number' => '4242424242424242',
            'card_exp_month' => 12,
            'card_exp_year' => 2024,
            'card_cvv' => '123',
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    final public function testExampleInvalidSystem(): void
    {
        $client = static::createClient();
        $client->request('POST', '/app/example/invalid', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'amount' => 100,
            'currency' => 'USD',
            'card_number' => '4242424242424242',
            'card_exp_month' => 12,
            'card_exp_year' => 2024,
            'card_cvv' => '123',
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
