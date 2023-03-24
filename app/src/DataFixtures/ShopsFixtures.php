<?php

namespace App\DataFixtures;

use App\Entity\Shops;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopsFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Shops::class, function (Shops $shops, int $index) {
            $shops
                ->setName($this->faker->firstName)
                ->setTags($this->getAlias($this->faker->text(150), ','))
                ->setText($this->faker->realText(1024))
                ->setDescription($this->faker->realText(255))
                ->setLogo("assets/images/shop-categories/0{$index}.png")
                ->setStatus('NEW')
                ->setRatings($this->faker->boolean() ? $this->faker->numberBetween(0, 100) : null)
                ->setVisit($this->faker->boolean() ? $this->faker->numberBetween(0, 1000) : null)
            ;
        }, 8);
    }
}
