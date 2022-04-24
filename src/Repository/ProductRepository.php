<?php

namespace App\Repository;

use App\Data\SearchInfo;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator=$paginator;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
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
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function filterbyName($prodName)
    {
        return $this->createQueryBuilder('N')
            ->where("N.prodName LIKE:prodName")
            ->setParameter('prodName','%'.$prodName.'%')
            ->getQuery()
            ->getResult();
    }

    public function findByName($prodName="")
    {
        return $this->createQueryBuilder("p")
            ->where("p.prodName like :prodName")
            ->setParameter("prodName","%".$prodName."%")
            ->getQuery()
            ->getResult();
    }
    /**
     * return Query
     *
     */
    public function  findAllVisible():Query{
        return $this->findAllVisibleQuery()->getQuery();
    }

    /**
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
public function search(SearchInfo $search): \Knp\Component\Pager\Pagination\PaginationInterface
{
    $query=$this
        ->createQueryBuilder('p')
        ->select('c','p')
       ->join('p.idCategory','c');

    if(!empty($search->q)){
        $query=$query
            ->andWhere('p.prodName LIKE :q')
            ->setParameter('q',"%{$search->q}%");
    }
   if(!empty($search->min)){
       $query=$query
           ->andWhere('p.price >= :min')
           ->setParameter('min',$search->min);
   }
    if(!empty($search->max)){
        $query=$query
            ->andWhere('p.price <= :max')
            ->setParameter('max',$search->max);
    }
    if(!empty($search->categories)){
        $query=$query
            ->andWhere('c.idCategory IN (:categories)')
            ->setParameter('categories',$search->categories);
    }
    $query =$query->getQuery();
    return $this->paginator->paginate(
        $query,$search->page,4
    );
}}