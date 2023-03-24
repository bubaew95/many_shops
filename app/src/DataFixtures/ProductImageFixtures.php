<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductImages;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductImageFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $product = $this->getRandomReference(Product::class);
            for ($j = 1; $j <= 5; $j++) {
                $productImages = new ProductImages();
                $productImages
                    ->setProduct($product)
                    ->setImage("assets/images/product-gallery/0{$j}.png")
                ;
                $manager->persist($productImages);
            }
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            ProductsFixtures::class,
        ];
    }
}
