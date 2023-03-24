<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends BaseFixtures
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(User::class, function (User $user) {
            $user
                ->setEmail($this->faker->email)
                ->setPassword($this->passwordHasher->hashPassword($user, 'test'))
            ;
        }, 10);
    }
}
