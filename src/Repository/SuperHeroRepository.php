<?php

namespace App\Repository;

use App\Entity\SuperHero;
use Doctrine\Common\Persistence\ManagerRegistry;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FOS\ElasticaBundle\Repository;

/**
 * @method SuperHero|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuperHero|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuperHero[]    findAll()
 * @method SuperHero[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperHeroRepository extends Repository
{
    public function search($search = null, $limit = 10)
    {
        $query = new Query();

        $boolQuery = new BoolQuery();

        if (!\is_null($search)) {
            $fieldQuery = new Query\MatchPhrasePrefix();
            $fieldQuery->setField('name', $search);

            $boolQuery->addMust($fieldQuery);
        }

        $query->setQuery($boolQuery);
        $query->setSize($limit);

        return $this->find($query);
    }

    // /**
    //  * @return SuperHero[] Returns an array of SuperHero objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SuperHero
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
