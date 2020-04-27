<?php


namespace App\Controller;


use App\Entity\Bids;
use App\Form\Type\BidType;
use App\Manager\BaseManager;
use App\Model\Interfaces\LotsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BidController extends AbstractController
{
    public function renderBidFormAction(LotsInterface $lot)
    {
        $form = $this->createForm(BidType::class, new Bids(), [
            'lot' => $lot,
            'user' => $this->getUser()
        ]);

        return $this->render('modules/bid-form.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ajax-save-bid", name="save_bid")
     * @return Response
     * @throws \Exception
     */
    public function ajaxSaveBidAction(Request $request, BaseManager $baseManager)
    {
        if ( $request->isXmlHttpRequest() ) {
            $form = $this->createForm(BidType::class, new Bids());

            $form->handleRequest($request);

            if($form->getData()->getUser() != $this->getUser()) {
                return new JsonResponse([
                    'result' => 401,
                    'message' => 'Unauthorized',
                    'data' => '',
                ]);
            }

            if($form->isSubmitted() && $form->isValid()) {
                $bid = $form->getData();
                $baseManager->save($bid);

                return new JsonResponse([
                    'result' => 1,
                    'message' => 'ok',
                    'data' => '',
                ]);
            }

            return new JsonResponse([
                'result' => 0,
                'message' => 'Invalid form',
                'data' => $this->getErrorMessages($form)
            ]);
        }

        throw new \Exception('Unauthorized request');
    }

    protected function getErrorMessages(Form $form)
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[] = $this->getErrorMessages($child)[0];
            }
        }

        return $errors;
    }
}