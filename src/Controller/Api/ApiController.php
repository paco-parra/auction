<?php

namespace App\Controller\Api;

use App\Entity\Auction;
use App\Entity\Bids;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/v1")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/users/all", name="api_user_list", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllUsers() {

        $this->denyAccessUnlessGranted('view', $this->getUser());

        $repository = $this->getDoctrine()->getRepository(User::class);
        $message = "";
        $users = [];

        try {
            $code = 200;
            $error = false;

            $users = $repository->findAllUsersAsArray();

            if (is_null($users)) {
                $users = [];
            }

        } catch (\Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Users - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $users : $message,
        ];

        return new JsonResponse($this->serialize($response, "json"));
    }

    /**
     * @Route("/auctions/all", name="api_auctions_list", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllAuctions() {

        $this->denyAccessUnlessGranted('view', $this->getUser());

        $repository = $this->getDoctrine()->getRepository(Auction::class);
        $message = "";
        $auctions = [];

        try {
            $code = 200;
            $error = false;

            $auctions = $repository->findAllAuctionArray();

            if (is_null($auctions)) {
                $auctions = [];
            }

        } catch (\Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Auctions - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $auctions : $message,
        ];

        return new JsonResponse($this->serialize($response));
    }

    /**
     * @Route("/user/{id}/bids", name="api_bids_by_user", methods={"GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function getBidsByUser(User $user) {

        $this->denyAccessUnlessGranted('view', $this->getUser());

        $repository = $this->getDoctrine()->getRepository(Bids::class);
        $message = "";
        $bids = [];

        try {
            $code = 200;
            $error = false;

            $bids = $repository->findBidsByUser($user);

            if (is_null($bids)) {
                $bids = [];
            }

        } catch (\Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Auctions - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $bids : $message,
        ];

        return new JsonResponse($this->serialize($response));
    }

    protected function serialize($data)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($data, 'json');
        return $json;
    }
}
