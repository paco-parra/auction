<?php
declare(strict_types=1);

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

class BaseManager
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create($class)
    {
        return new $class;
    }

    public function save($entity, $andFlush = true)
    {
        $this->entityManager->persist($entity);

        if ($andFlush) {
            $this->entityManager->flush();
        }
    }
}