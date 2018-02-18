<?php

namespace StoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository 
{

    public function findLastProducts($limit) {
        return $this
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute()
        ;
    }

    public function findFamousProducts($limit) {
        return $this
            ->createQueryBuilder('p')
            ->join('p.opinion', 'o')
            ->groupBy('p.id')
            ->addSelect('COUNT(o) as oSum')
            ->orderBy('oSum', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute()
            ;
    }

    public function findBySearch($title) {
        return $this
            ->createQueryBuilder('p')
            ->where('p.title LIKE :title')
            ->setParameter(':title', '%'.$title.'%')
            ->getQuery()
            ->execute()
            ;
    }
}
