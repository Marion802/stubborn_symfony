<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentTest extends WebTestCase
{
    public function testPaymentRedirect(): void
    {
        $client = static::createClient();

        // Initialiser la session
        $client->request('GET', '/');

        $session = $client->getRequest()->getSession();
        $session->set('cart', [
            1 => [
                'size' => 'M',
                'quantity' => 1
            ]
        ]);

        $client->request('GET', '/payment');

        $this->assertResponseRedirects();
    }
}
