<?php

namespace App\Controller\Api;

use App\Entity\Auction;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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

            $users = $repository->findAll();

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

            $auctions = $repository->findAll();

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

        return new JsonResponse($this->serialize($response, "json"));
    }

    private function serialize(array $response)
    {
        $encoders = [new JsonEncoder()];

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];

        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($response, 'json');

        return $json;
    }
}
