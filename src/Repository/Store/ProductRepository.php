<?php

namespace App\Repository\Store;

use App\Entity\Store\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findFour()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(4);

        dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }

    public function findPopulaires()
    {
        /* 
        $qb = $this->createQueryBuilder('b')
            ->addSelect('b')
            ->leftJoin('p.comment','b')
            ->where('p.id = :id_produit')
            -> 
            */
    }

    /* public function myFindAll(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.name = :name')
            ->setParameter('name', $name);

        $this->whereCurrentYear($qb);

        $qb->orderBy('p.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    } */
}
