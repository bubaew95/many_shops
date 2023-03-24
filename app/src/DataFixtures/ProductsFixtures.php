<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ShopCategories;
use App\Entity\Shops;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductsFixtures extends BaseFixtures implements DependentFixtureInterface
{

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Product::class, function (Product $products, $i) use($manager){
            $title = $this->faker->realText('50');

            if ($i <= 9) {
                $i = "0{$i}";
            }

            $shop     = $this->getRandomReference(Shops::class);
            $category = $this->getRandomReference(Category::class);

            $this->addShopCategory($category, $shop, $manager);


            $products
                ->setName($title)
                ->setImage("assets/images/products/{$i}.png")
                ->setPrice($this->faker->numberBetween(100, 9999))
                ->setDiscount($this->faker->boolean() ? $this->faker->numberBetween(5, 99) : null)
                ->setDescription($this->faker->realText(255))
                ->setTags($this->getAlias($this->faker->text(150), ','))
                ->setText($this->faker->realText(1024))
                ->setRatings($this->faker->boolean() ? $this->faker->numberBetween(0, 1000) : null)
                ->setCategory($category)
                ->setShop($shop);
        }, 20);
    }

    /**
     * @param object $category
     * @param object $shop
     * @param ObjectManager $manager
     * @return void
     */
    function addShopCategory(object $category, object $shop, ObjectManager $manager): void
    {
        $shopCategory = new ShopCategories();
        $shopCategory
            ->setCategory($category)
            ->setShop($shop);
        $manager->persist($shopCategory);
    }


    public function getDependencies(): array
    {
        return [
            ShopsFixtures::class,
            CategoryFixtures::class
        ];
    }
}
