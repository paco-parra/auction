<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Auction;
use App\Manager\BaseManager;
use App\Model\Interfaces\AuctionInterface;
use App\Model\Interfaces\LotsInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
//    public $auctionManager;
//
//    public function __construct(AuctionManager $auctionManager)
//    {
//        $this->auctionManager = $auctionManager;
//    }

    /**
     * @Route("/", name="home")
     */
    public function indexAction(BaseManager $baseManager)
    {
//        $service = $this->get(BidsService::class);
//        $manager = $this->get('app.auction.manager');
        $auctionRepository = $this->getDoctrine()->getRepository(Auction::class);
        $auctions = $auctionRepository->findLatestAuction();

        return $this->render('views/home.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    /**
     * @Route("/auctions", name="auctions_list")
     */
    public function auctionsListAction()
    {
        $auctionRepository = $this->getDoctrine()->getRepository(Auction::class);
        $auctions = $auctionRepository->findNonExpiredAuctions();

        return $this->render('views/auction-list.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    /**
     * @Route("/lots/{id}", name="lots_list")
     * @ParamConverter("auction", class="App\Entity\Auction")
     * @param AuctionInterface $auction
     * @return Response
     */
    public function lotsListAction(AuctionInterface $auction)
    {
        $lots = $auction->getLots();

        return $this->render('views/lots-list.html.twig', [
            'auctionName' => $auction->getName(),
            'lots' => $lots,
        ]);
    }

    /**
     * @Route("/lot/{id}", name="lot_view")
     * @ParamConverter("lot", class="App\Entity\Lots")
     * @param LotsInterface $lot
     * @return Response
     */
    public function lotViewAction(LotsInterface $lot)
    {
        return $this->render('views/lots-view.html.twig', [
            'lot' => $lot,
        ]);
    }
}
