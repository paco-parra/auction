<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Auction;
use App\Entity\Lots;
use App\Entity\Products;
use App\Manager\BaseManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadApplicationData extends Fixture implements ContainerAwareInterface
{
    protected $container;
    protected $baseManager;

    public function __construct(BaseManager $baseManager)
    {
        $this->baseManager = $baseManager;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUserData();
        $this->loadAuctionData();
        $this->loadLotsData();
        $this->loadProductsData();
    }

    private function loadUserData()
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('admin@admin.com');
        $user->setEmail('admin@admin.com');
        $user->setPlainPassword('12345');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);

        $userManager->updateUser($user);
    }

    private function loadAuctionData()
    {
        $items = [
            [
                'name' => 'Subasta Valencia',
                'availableAt' => new \DateTime('2020-04-20 12:00:00'),
                'expiredAt' => new \DateTime('2020-06-20 12:00:00'),
            ],
            [
                'name' => 'Subasta Madrid',
                'availableAt' => new \DateTime('2020-05-15 12:00:00'),
                'expiredAt' => new \DateTime('2020-07-15 12:00:00'),
            ],
            [
                'name' => 'Subasta Galicia',
                'availableAt' => new \DateTime('2020-04-20 12:00:00'),
                'expiredAt' => new \DateTime('2020-06-20 12:00:00'),
            ],
            [
                'name' => 'Subasta Barcelona',
                'availableAt' => new \DateTime('2020-04-20 12:00:00'),
                'expiredAt' => new \DateTime('2020-06-20 12:00:00'),
            ],
        ];

        foreach ($items as $key => $item) {
            $auction = $this->baseManager->create(Auction::class);

            $auction->setName($item['name']);
            $auction->setExpiredAt($item['expiredAt']);
            $auction->setAvailableAt($item['availableAt']);

            $this->baseManager->save($auction);

            $this->addReference(sprintf('auction-%s', $key), $auction);
        }
    }

    private function loadLotsData()
    {
        for ($i=0; $i < 13; $i++) {
            $lot = $this->baseManager->create(Lots::class);

            $lot->setName(sprintf('Lote %s', $i));
            $lot->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed nisl in leo rhoncus pulvinar in sit amet augue. Donec turpis tortor, venenatis a tristique in, maximus non erat. Nulla vitae vulputate odio, vitae ullamcorper metus. Maecenas molestie laoreet lectus et faucibus. Integer egestas ultrices feugiat. Aenean in dapibus enim. Curabitur non accumsan velit. Ut nec tellus vitae turpis consectetur.');
            $lot->setPrice(rand(500, 15000));
            $lot->setInitialPrice(0);
            $lot->setAuction($this->getReference(sprintf('auction-%s', rand(0,3))));

            $this->baseManager->save($lot);

            $this->addReference(sprintf('lot-%s', $i), $lot);
        }
    }

    private function loadProductsData()
    {
        for ($i=0; $i < 40; $i++) {
            $product = $this->baseManager->create(Products::class);

            $product->setName(sprintf('Producto %s', $i));
            $product->setImage(' https://via.placeholder.com/600');
            $product->setLot($this->getReference(sprintf('lot-%s', rand(0,9))));

            $this->baseManager->save($product);
        }
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
