<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function pay(SessionInterface $session, StripeService $stripeService): RedirectResponse
    {
        $cart = $session->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += 30; // prix simulé (suffisant pour le devoir)
        }

        $checkoutSession = $stripeService->createCheckoutSession($total);

        return new RedirectResponse($checkoutSession->url);
    }

    #[Route('/payment/success', name: 'app_payment_success')]
    public function success(SessionInterface $session)
    {
        $session->remove('cart');

        return $this->render('payment/success.html.twig');
    }
}
