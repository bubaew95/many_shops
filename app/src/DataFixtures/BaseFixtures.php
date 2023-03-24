<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use http\Exception\RuntimeException;

abstract class BaseFixtures extends Fixture
{
    /**
     * @var \Faker\Generator
     */
    protected \Faker\Generator $faker;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $manager;

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $this->faker    = Factory::create();
        $this->manager  = $manager;
        $this->loadData($manager);
    }

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    abstract public function loadData(ObjectManager $manager);

    /**
     * @param string $className
     * @param callable $factory
     * @param int $count
     * @return void
     */
    protected function createMany(string $className, callable $factory, int $count): void
    {
        for($i = 0; $i < $count; $i++) {
            $entity = $this->create($className, $factory, $i);
            $this->addReference("{$className}|{$i}", $entity);
        }
        $this->manager->flush();
    }

    /**
     * @param string $className
     * @param callable $factory
     * @param int $index
     * @return mixed
     */
    protected function create(string $className, callable $factory, int $index = 0): mixed
    {
        $entity = new $className();
        $factory($entity, $index);

        $this->manager->persist($entity);

        return $entity;
    }


    private array $referencesIndex = [];

    /**
     * @throws \Exception
     */
    protected function getRandomReference($className): object
    {
        if( !isset($this->referencesIndex[$className]) ) {
            $this->referencesIndex[$className] = [];
            foreach ($this->referenceRepository->getReferences() as $key => $referenceName) {
                if(str_starts_with($key, $className . '|')) {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }
        dump($this->referencesIndex);

        if(empty($this->referencesIndex[$className])) {
            throw new \Exception("Не найдены ссылки на класс: {$className}");
        }

        return $this->getReference($this->faker->randomElement($this->referencesIndex[$className]));
    }

    /**
     * @param  string  $title
     *
     * @return string
     */
    protected function getAlias(string $title, string $replace = '-') : string
    {
        return str_replace([' ', ',', '-'], $replace, strtolower(
            str_replace([',', '.', '!', '?', '(', ')', '[', ']'], '', $title)
        ));
    }

}
