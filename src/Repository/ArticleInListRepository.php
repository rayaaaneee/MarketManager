<?php

namespace App\Repository;

use App\Entity\ArticleInList;
use App\Entity\ShoppingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleInList>
 *
 * @method ArticleInList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleInList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleInList[]    findAll()
 * @method ArticleInList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleInListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleInList::class);
    }

    public function save(ArticleInList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArticleInList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByAllByShoppingListQuery(ShoppingList $shoppingList): Query
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder
            ->where('a.shoppingList = :shoppingList')
            ->setParameter('shoppingList', $shoppingList->getId());

        return $queryBuilder->getQuery();
    }

    //    /**
    //     * @return ArticleInList[] Returns an array of ArticleInList objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ArticleInList
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
