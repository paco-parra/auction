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

    /**
     * @return int
     */
    public function getOffer():? int
    {
        return $this->offer;
    }

    /**
     * @param int $offer
     */
    public function setOffer(int $offer): void
    {
        $this->offer = $offer;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * @param mixed $lot
     */
    public function setLot($lot): void
    {
        $this->lot = $lot;
    }
}