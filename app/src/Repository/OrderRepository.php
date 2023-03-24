<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findByUserIdOrSessionId(int $cartId, ?User $user)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.orderItem', 'i')
            ->addSelect('i')
            ->orWhere('o.id = :cart_id')
            ->setParameter('cart_id', $cartId)
            ->orWhere('o.user = :user_id')
            ->setParameter('user_id', $user->getId())
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCartId($id)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.orderItem', 'oi')
            ->andWhere('o.id = :id')
            ->andWhere('o.status = :status')
            ->setParameters([
                'id' => $id,
                'status' => Order::STATUS_CART
            ])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
