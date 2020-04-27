<?php


namespace App\Controller;


use App\Model\Interfaces\LotsInterface;
use App\Services\BidsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BidController extends AbstractController
{
    /**
     * @Route("/create-bid/{id}", name="create_bid")
     * @ParamConverter("lot", class="App\Entity\Lots")
     * @param LotsInterface $lot
     * @return Response
     */
    public function createBidAction(LotsInterface $lot)
    {
        $service = $this->get(BidsService::class);

        return;
    }
}