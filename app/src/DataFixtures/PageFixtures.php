<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Pages;
use App\Entity\Shops;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Pages::class, function (Pages $pages) {
            $pages
                ->setTitle($this->faker->realText(40))
                ->setDescription($this->faker->realText(255))
                ->setTags($this->getAlias($this->faker->text(150), ','))
                ->setText($this->faker->realText(1024))
                ->setStatus('publish')
            ;

            if ($this->faker->boolean()) {
                $pages->setShop(
                    $this->getRandomReference(Shops::class)
                );
                $pages->setCategory(
                    $this->getRandomReference(Category::class)
                );
            } else {
                $pages->setLink(
                    $this->getAlias($this->faker->realText(10))
                );
            }


        }, 10);
    }
}
