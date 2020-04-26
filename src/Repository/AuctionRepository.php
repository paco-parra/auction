<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class AuctionRepository extends EntityRepository
{
    public function findLatestAuction($limit = 3)
    {
        $qb = $this->findNonExpiredAuctions(true);
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function findNonExpiredAuctions($onlyBuilder = null)
    {
        $qb = $this->createQueryBuilder('auction');
        $qb->where('auction.expiredAt > :expiredAt');
        $qb->setParameter('expiredAt', new \DateTime());

        if($onlyBuilder) {
            return $qb;
        }
        return $qb->getQuery()->getResult();
    }
}