<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Property::class);
        $this->paginator = $paginator;
    }

    /**
     * Retrieves products related to a search
     * @param SearchData $searchData
     * @return PaginationInterface
     */
    public function findSearch(SearchData $searchData): PaginationInterface
    {
        $query = $this->getSearchQuery($searchData)->getQuery();
        return $this->paginator->paginate(
            $query,
            $searchData->page,
            9
        );
    }

    /**
     * Retrieves the minimum and maximum price corresponding to a search
     * @param SearchData $searchData
     * @return int[]
     */
    public function findMinMax(SearchData $searchData): array
    {
        $results = $this->getSearchQuery($searchData, true)
            ->select('MIN(p.price) as min', 'MAX(p.price) as max')
            ->getQuery()
            ->getScalarResult();

        return [(int)$results[0]['min'], (int)$results[0]['max']];
    }

    private function getSearchQuery(SearchData $searchData, $ignorePrice = false): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.categories', 'c');

        if (!empty($searchData->min) && $ignorePrice === false) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $searchData->min);
        }

        if (!empty($searchData->max) && $ignorePrice === false) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $searchData->max);
        }

        if (!empty($searchData->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $searchData->categories);
        }

        return $query;
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
