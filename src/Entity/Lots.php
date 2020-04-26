<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\Interfaces\AuctionInterface;
use App\Model\Interfaces\LotsInterface;
use App\Model\Interfaces\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lots")
 * @ORM\Entity(repositoryClass="App\Repository\LotsRepository")
 */
class Lots implements LotsInterface
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
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $price;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $initialPrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Products", mappedBy="lot", orphanRemoval=true)
     **/
    protected $products;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auction", inversedBy="lots")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id")
     */
    protected $auction;

    public function __construct()
    {
        $this->products = [];
        $this->initialPrice = 0;
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
    public function getName():? string
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
    public function getDescription():? string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPrice():? int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getInitialPrice():? int
    {
        return $this->initialPrice;
    }

    /**
     * @param int $initialPrice
     */
    public function setInitialPrice(int $initialPrice): void
    {
        $this->initialPrice = $initialPrice;
    }

    /**
     * @return mixed
     */
    public function getProducts() :? iterable
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    public function addProducts(ProductInterface $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProducts(ProductInterface $product = null)
    {
        if (!$this->products->contains($product)) {
            $this->products->removeElement($product);
        }
    }

    /**
     * @return mixed
     */
    public function getAuction():? AuctionInterface
    {
        return $this->auction;
    }

    /**
     * @param mixed $auction
     */
    public function setAuction(AuctionInterface $auction): void
    {
        $this->auction = $auction;
    }
}