<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_admin_delete')]
    public function delete(Product $product, EntityManagerInterface $em): Response
    {
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('app_admin');
    }
}
