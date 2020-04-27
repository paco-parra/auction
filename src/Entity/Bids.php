<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\Interfaces\BidsInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bids")
 * @ORM\Entity(repositoryClass="App\Repository\BidsRepository")
 */
class Bids implements BidsInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $offer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bids")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lots", inversedBy="bids")
     * @ORM\JoinColumn(name="lot_id", referencedColumnName="id")
     */
    protected $lot;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}