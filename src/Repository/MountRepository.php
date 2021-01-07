<?php

namespace App\Repository;

use App\Entity\Mount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mount[]    findAll()
 * @method Mount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mount::class);
    }


    public function findAllQueryBuilder($filter_name = '', $filter_fact = '', $filter_type = '', $filter_ext = '', $filter_source = '', $filter_curr = '')
    {
        $qb = $this->createQueryBuilder('mount');
        if ($filter_name) {
            $qb->andWhere('mount.name LIKE :name')
                ->setParameter('name', '%'.$filter_name.'%');
        }

        if ($filter_fact) {
            $qb->andWhere('mount.faction LIKE :fact')
                ->setParameter('fact', '%'.$filter_fact.'%');
        }

        if ($filter_type) {
            $qb->andWhere('mount.type LIKE :type')
                ->setParameter('type', '%'.$filter_type.'%');
        }

        if ($filter_ext) {
            $qb->leftJoin('App\Entity\Expansion', 'e', Join::WITH, 'mount.expansion = e.id')
                ->andWhere('e.name LIKE :ext')
                ->setParameter('ext', '%'.$filter_ext.'%');
        }

        if ($filter_source) {
            $qb->leftJoin('App\Entity\Source', 's', Join::WITH, 'mount.source = s.id')
                ->andWhere('s.name LIKE :source')
                ->setParameter('source', '%'.$filter_source.'%');
        }

        if ($filter_curr) {
            $qb->leftJoin('App\Entity\CurrencyType', 'c', Join::WITH, 'mount.currency_type = c.id')
                ->andWhere('c.name LIKE :curr')
                ->setParameter('curr', '%'.$filter_curr.'%');
        }




        return $qb;
    }


    // /**
    //  * @return Mount[] Returns an array of Mount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mount
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
