<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\Interfaces\LotsInterface;
use App\Model\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Products implements ProductInterface
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
     * @var string
     * @TODO: This must be a File entity, but is not required for now
     * @ORM\Column(type="string")
     */
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lots", inversedBy="products")
     * @ORM\JoinColumn(name="lot_id", referencedColumnName="id")
     */
    protected $lot;

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
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getLot(): LotsInterface
    {
        return $this->lot;
    }

    /**
     * @param mixed $lot
     */
    public function setLot(LotsInterface $lot): void
    {
        $this->lot = $lot;
    }
}