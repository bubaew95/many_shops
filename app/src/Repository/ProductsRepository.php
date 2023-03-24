<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Somnambulist\Components\CTEBuilder\ExpressionBuilder;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return QueryBuilder
     */
    public function findByLimit(string $category = null): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');
    }

    public function recursiveCTE(string $alias)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT p, c FROM App\Entity\Product p 
            inner join App\Entity\Category c
            with p.category = c
            WHERE p.category in (
                select c1.id
                from App\Entity\Category c1, App\Entity\Category c2
                WHERE c1.lft >= c2.lft AND c1.rgt <= c2.rgt
                AND c2.alias = :alias
            )
        ')->setParameters([
            'alias' => $alias
        ]);

        //        $entityManager = $this->getEntityManager();
//        $queryBuilder = $entityManager->createQueryBuilder();
//
//        $expr = $queryBuilder->expr();
//
//        $queryBuilder
//            ->select('c1.id, c1.title')
//            ->from('App\Entity\Category', 'c1')
//            ->join('App\Entity\Category', 'c2', Join::ON, $expr->andX(
//                $expr->gte('c1.lft', 'c2.lft'),
//                $expr->lte('c1.rgt', 'c2.rgt')
//            ))
//        ;
//
//        dd($queryBuilder->getQuery()->getResult());
//
//        return null;
//        $queryBuilder
//            ->andWhere($queryBuilder->expr()->in('p.category', ));

        return $query->getResult();
    }

    /**
     * Вывод товаров по магазинам
     *
     * @param  string  $shopName
     *
     * @return QueryBuilder
     */
    public function findProductsByShop(string $shopName) : QueryBuilder
    {
        return $this->createQueryBuilder('p')
//            ->join('p.category', 'c')
            ->innerJoin('p.shop', 's')
            ->andWhere('s.alias = :shop')
            ->setParameter('shop', $shopName)
        ;
    }

    /**
     * @param  string  $shopName
     *
     * @return float|int|mixed|string
     */
    public function findProductsByShopResult(string $shopName)
    {
        return $this->findProductsByShop($shopName)
            ->getQuery()
            ->getResult()
        ;
    }

}
