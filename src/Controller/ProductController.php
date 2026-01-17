<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $priceFilter = $request->query->get('price');

        if ($priceFilter === '10-29') {
            $products = $productRepository->findByPriceRange(10, 29);
        } elseif ($priceFilter === '29-35') {
            $products = $productRepository->findByPriceRange(29, 35);
        } elseif ($priceFilter === '35-50') {
            $products = $productRepository->findByPriceRange(35, 50);
        } else {
            $products = $productRepository->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'selectedPrice' => $priceFilter,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_show')]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

         return $this->render('product/show.html.twig', [
            'product' => $product,
    ]);
    }

}
