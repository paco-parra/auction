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

    public function findAllAuctionArray()
    {
        $qb = $this->findNonExpiredAuctions(true);
        $qb->select(
            'auction.name as auctionName, auction.expiredAt, auction.availableAt, 
            lots.name as lotName, lots.price as lotPrice, lots.description as lotDescription,
            product.name as productName'
        )
            ->leftJoin('auction.lots', 'lots')
            ->leftJoin('lots.products', 'product');

        $resultQb = $qb->getQuery()->getArrayResult();

        $result = [];
        foreach ($resultQb as $item) {
            if(!key_exists($item['auctionName'], $result)) {
                $result[$item['auctionName']] = [
                    'expiredAt' => $item['expiredAt'],
                    'availableAt' => $item['availableAt'],
                    'lots' => [],
                ];
            }
            if(!key_exists($item['lotName'], $result[$item['auctionName']]['lots'])) {
                $result[$item['auctionName']]['lots'][$item['lotName']] = [
                    'price' => $item['lotPrice'],
                    'description' => $item['lotDescription'],
                ];
            }

            $result[$item['auctionName']]['lots'][$item['lotName']]['products'][] = [
                'name' => $item['productName']
            ];
        }

        return $result;
    }
}