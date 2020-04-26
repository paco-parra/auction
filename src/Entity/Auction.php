<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\Interfaces\AuctionInterface;
use App\Model\Interfaces\LotsInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="auction")
 * @ORM\Entity(repositoryClass="App\Repository\AuctionRepository")
 */
class Auction implements AuctionInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $expiredAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $availableAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lots", mappedBy="auction", orphanRemoval=true)
     **/
    protected $lots;

    public function __construct()
    {
        $this->lots = [];
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getExpiredAt() :? \DateTime
    {
        return $this->expiredAt;
    }

    /**
     * @param mixed $expiredAt
     */
    public function setExpiredAt(\DateTime $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }

    /**
     * @return mixed
     */
    public function getAvailableAt() :? \DateTime
    {
        return $this->availableAt;
    }

    /**
     * @param mixed $availableAt
     */
    public function setAvailableAt(\DateTime $availableAt): void
    {
        $this->availableAt = $availableAt;
    }

    /**
     * @return mixed
     */
    public function getLots() :? iterable
    {
        return $this->lots;
    }

    /**
     * @param mixed $lots
     */
    public function setLots($lots): void
    {
        $this->lots = $lots;
    }

    public function addLots(LotsInterface $lot)
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->add($lot);
        }

        return $this;
    }

    public function removeLots(LotsInterface $lot = null)
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->removeElement($lot);
        }
    }
}