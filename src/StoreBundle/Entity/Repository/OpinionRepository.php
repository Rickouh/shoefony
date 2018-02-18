<?php

namespace StoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class OpinionRepository extends EntityRepository
{
    public function findByProductId($productId) {
        return $this
            ->createQueryBuilder('o')
            ->where('o.product =' . $productId)
            ->getQuery()
            ->execute()
            ;
    }
}