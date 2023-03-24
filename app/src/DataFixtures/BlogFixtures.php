<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(News::class, function (News $blog, int $index) {
            $index++;
            $blog
                ->setTitle($this->faker->text($this->faker->numberBetween(10, 30)))
                ->setImage("assets/images/blogs/0{$index}.png")
                ->setDescription($this->faker->realText(244))
                ->setText($this->faker->realText(1024))
                ->setStatus('publish')
                ->setTags('News,test,article 1,instagram')
            ;
        }, 6);
    }
}
