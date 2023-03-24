<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Interfaces\StatusesInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixtures implements StatusesInterface
{
    public const PAGES = [
        'about'    => 'О нас',
        'news'     => 'Новости',
        'contacts' => 'Контакты'
    ];

    public function loadData(ObjectManager $manager)
    {
        //Добавляет категорию главной страницы
        $this->create(Category::class, function (Category $category) {
            $category
                ->setTitle("Главная")
                ->setStatus(self::STATUS_PUBLISH)
                ->setPosition(1);
        });

        foreach (self::PAGES as $key => $item) {
            $catalogCategory = new Category();
            $catalogCategory
                ->setTitle($item)
                ->setStatus(self::STATUS_PUBLISH)
                ->setAlias($key)
                ->setPosition(4);
            $manager->persist($catalogCategory);
        }

        //Добавляет категорию с товарами
        $shopsCategory = new Category();
        $shopsCategory
            ->setTitle("Магазины")
            ->setAlias('/shops')
            ->setStatus(self::STATUS_PUBLISH)
            ->setPosition(3);
        $manager->persist($shopsCategory);

        //Добавляет категорию с товарами
        $catalogCategory = new Category();
        $catalogCategory
            ->setTitle("Каталог")
            ->setAlias('catalog')
            ->setStatus(self::STATUS_PUBLISH)
            ->setPosition(2);
        $manager->persist($catalogCategory);

        $banerCategory = new Category();
        $banerCategory
            ->setParent($catalogCategory)
            ->setTitle('Банер')
            ->setBanner('assets/images/gallery/menu-img.jpg')
            ->setStatus(self::STATUS_PUBLISH);
        $manager->persist($banerCategory);

        //Добавляет первую категорию
        $this->createMany(Category::class, function (Category $category) use ($catalogCategory, $manager) {
            $category
                ->setTitle($this->faker->text(20))
                ->setParent($catalogCategory)
                ->setStatus(self::STATUS_PUBLISH);

            for ($i = 0; $i < $this->faker->numberBetween(5, 10); $i++) {
                $this->addChildrens($category, $manager);
            }
        }, 2);
    }

    private function addChildrens(Category $catalogOne, ObjectManager $manager): void
    {
        $category = new Category();
        $category
            ->setTitle($this->faker->realText(15))
            ->setParent($catalogOne)
            ->setStatus(self::STATUS_PUBLISH);
        $manager->persist($category);
    }

}
