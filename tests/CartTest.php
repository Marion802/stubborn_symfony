<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartTest extends WebTestCase
{
    public function testAddProductToCart(): void
    {
        $client = static::createClient();

        // Initialiser la session
        $client->request('GET', '/');

        // Ajouter un produit
        $client->request('POST', '/cart/add/1', [
            'size' => 'M'
        ]);

        // Récupérer la session APRÈS la requête POST
        $session = $client->getRequest()->getSession();
        $cart = $session->get('cart');

        $this->assertNotEmpty($cart);
        $this->assertArrayHasKey(1, $cart);
        $this->assertEquals('M', $cart[1]['size']);
    }
}
