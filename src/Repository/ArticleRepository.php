<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Article>
 * 
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllArticle()
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }

    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('a')
            ->getQuery();
    }


    public function findByNameAndTypeQuery(array $data): array | Query
    {
        $keyword = $data['search'];
        $type = $data['type'];

        $queryBuilder = $this->createQueryBuilder('a');

        // Ajouter une condition LIKE pour rechercher les variations de mots-clés
        $queryBuilder
            ->where('a.name LIKE :keyword')
            ->orWhere('a.name LIKE :keywordStart')
            ->orWhere('a.name LIKE :keywordEnd')
            ->orWhere('a.name LIKE :keywordMiddle')
            ->setParameter('keyword', "%{$keyword}%")
            ->setParameter('keywordStart', "{$keyword}%")
            ->setParameter('keywordEnd', "%{$keyword}")
            ->setParameter('keywordMiddle', "%{$keyword}%");
        if ($type !== null) {
            $queryBuilder
                ->andWhere('a.type = :type')
                ->setParameter('type', $type);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
