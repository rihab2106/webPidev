<?php

namespace App\Repository;

use App\Entity\Competitions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Competitions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competitions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competitions[]    findAll()
 * @method Competitions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competitions::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Competitions $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Competitions $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Competitions[] Returns an array of Competitions objects
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
    public function findOneBySomeField($value): ?Competitions
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByName($name="")
    {
        return $this->createQueryBuilder("c")
            ->where("c.gameName like :gameName")
            ->setParameter("gameName",$name."%")
            ->getQuery()
            ->getResult();
    }


    public function OrderByName()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select n from App\Entity\Competitions n order by n.gameName DESC');
        return $query->getResult();
    }
}
