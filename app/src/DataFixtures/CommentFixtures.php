<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\Comments;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Comments::class, function (Comments $comments) {

            $comments
                ->setUser($this->getRandomReference(User::class))
                ->setStatus('publish')
                ->setText($this->faker->realText($this->faker->numberBetween(50, 255)));

            if ($this->faker->boolean()) {
                $comments->setNews($this->getRandomReference(News::class));
            } else {
                $comments->setProduct($this->getRandomReference(Product::class));
            }

        }, 100);
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
            ProductsFixtures::class,
            BlogFixtures::class,
        ];
    }
}
