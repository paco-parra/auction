<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class BidsRepository extends EntityRepository
{
    public function findBidsByUser(User $user)
    {
        $qb = $this->createQueryBuilder('bids');
        $qb->select('bids.offer, lots.name, user.email')
        ->join('bids.lot', 'lots')
        ->join('bids.user', 'user');

        return $qb->getQuery()->getArrayResult();
    }
}