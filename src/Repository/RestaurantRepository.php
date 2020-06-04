<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findId()
    {
        return $this->createQueryBuilder('r')
            ->select('r.id')
            ->getQuery()
            ->getResult();
    }

    public function findTenLast()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.created_at', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findTenBest2()
    {
        return $this->createQueryBuilder('r')
            ->select('r.nom', 'avg(a.note)')
            ->innerJoin('Avis', 'a', 'WITH', 'r.id = a.restaurant_id')
            ->groupBy('r.nom')
            ->orderBy('avg(a.note)', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findTenBest($restaurants): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r.nom, AVG(a.note) as moyenne
            FROM App\Entity\Restaurant r
            inner join App\Entity\Avis a
            on r.id = a.restaurant_id
            GROUP BY r.nom
            order by moyenne desc
            limit 10'
        )->setParameter('restaurants', $restaurants);

        // returns an array of Product objects
        return $query->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Restaurant
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
