<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['Blackbelt', 29.90, 'Blackbelt.jpeg', true],
            ['BlueBelt', 29.90, 'BlueBelt.jpeg', false],
            ['Street', 34.50, 'Street.jpeg', false],
            ['Pokeball', 45.00, 'Pokeball.jpeg', true],
            ['PinkLady', 29.90, 'PinkLady.jpeg', false],
            ['Snow', 32.00, 'Snow.jpeg', false],
            ['Greyback', 28.50, 'Greyback.jpeg', false],
            ['BlueCloud', 45.00, 'BlueCloud.jpeg', false],
            ['BornInUsa', 59.90, 'Borninusa.jpeg', true],
            ['GreenSchool', 42.20, 'GrennSchool.jpeg', false],
        ];

        foreach ($products as [$name, $price, $image, $featured]) {
            $product = new Product();
            $product->setProduct($name);
            $product->setPrice($price);
            $product->setImage($image);
            $product->setFeatured($featured);

            // Stock par taille (au moins 2)
            $product->setStockXS(5);
            $product->setStockS(5);
            $product->setStockM(5);
            $product->setStockL(5);
            $product->setStockXL(5);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
