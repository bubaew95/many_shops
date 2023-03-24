<?php

namespace App\Repository;

use App\Entity\Category;
use App\Interfaces\StatusesInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends NestedTreeRepository implements StatusesInterface
{
    public function __construct(EntityManagerInterface $registry)
    {
        parent::__construct($registry, $registry->getClassMetadata(Category::class));
    }

    public function add(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function getTreeCategories(): array
    {
        return $this->queryBuilderForTree()
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function getTreeCategoriesForShop(string $shop): array
    {
        return $this->queryBuilderForTree()
            ->innerJoin('c.shopCategories', 'SC')
            ->innerJoin('SC.shop', 'S')
            ->andWhere("S.alias = :shop")       //Проверка что категории от нужного магазина
            ->setParameter('shop', $shop)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param  QueryBuilder|null  $queryBuilder
     *
     * @return QueryBuilder
     */
    private function queryBuilderForTree(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        $queryBuilder = $queryBuilder ?? $this->createQueryBuilder('c');
        return $queryBuilder
            ->orderBy('c.root, c.lft', 'ASC')
            ->andWhere("c.status = :status") //Проверка чтобы был нужный статус
            ->andWhere(
                $this->rootIds($queryBuilder)
            ) //Получаем ID родительского категория
            ->setParameter('status', self::STATUS_PUBLISH)
        ;
    }

    /**
     * ID родителей
     *
     * @param $db
     *
     * @return mixed
     */
    private function rootIds($db): mixed
    {
        return $db->expr()->notIn('c.root', $this->createQueryBuilder('cr')
            ->select('cr.id')
            ->where('cr.status != :status')
            ->getDQL()
        );
    }
}
