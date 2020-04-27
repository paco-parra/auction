<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllUsersAsArray()
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('user.email as userMail, user.enabled, user.lastLogin, bids.offer as bidOffer, lots.name as lotName')
            ->join('user.bids', 'bids')
            ->join('bids.lot', 'lots');

        $resultQb = $qb->getQuery()->getArrayResult();

        $result = [];
        foreach ($resultQb as $item) {
            if(!key_exists($item['userMail'], $result)) {
                $result[$item['userMail']] = [
                    'enabled' => $item['enabled'],
                    'lastLogin' => $item['lastLogin'],
                    'bids' => [],
                ];
            }
            $result[$item['userMail']]['bids'][] = [
                'lot' => $item['lotName'],
                'offer' => $item['bidOffer'],
            ];
        }

        return $result;
    }
}