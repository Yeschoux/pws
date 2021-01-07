<?php

namespace App\Repository;

use App\Entity\CurrencyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CurrencyType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyType[]    findAll()
 * @method CurrencyType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyType::class);
    }

    // /**
    //  * @return CurrencyType[] Returns an array of CurrencyType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CurrencyType
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
