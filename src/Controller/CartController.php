<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(
        int $id,
        Request $request,
        ProductRepository $productRepository,
        SessionInterface $session
    ): Response {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable');
        }

        $size = $request->request->get('size');

        $cart = $session->get('cart', []);

        $cart[$id] = [
            'size' => $size,
            'quantity' => 1
        ];

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(
        SessionInterface $session,
        ProductRepository $productRepository
    ): Response {
        $cart = $session->get('cart', []);
        $cartData = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = $productRepository->find($id);
            if ($product) {
                $cartData[] = [
                    'product' => $product,
                    'size' => $item['size'],
                    'quantity' => $item['quantity']
                ];
                $total += $product->getPrice() * $item['quantity'];
            }
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartData,
            'total' => $total
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(int $id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        unset($cart[$id]);
        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }
}
