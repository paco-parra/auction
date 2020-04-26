<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bids")
 * @ORM\Entity(repositoryClass="App\Repository\BidsRepository")
 */
class Bids implements ProductInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}