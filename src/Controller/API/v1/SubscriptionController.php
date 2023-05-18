<?php

namespace App\Controller\API\v1;

use App\Factory\APIResponseFactory;
use App\Repository\DeviceRepository;
use App\Service\SubscriptionService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription/check', name: 'api_check_subscription', methods: 'POST')]
    public function check(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);
        $token = $jsonData["clientToken"];

        $deviceRepositoryInstance = new DeviceRepository($doctrine);
        $subscriptionService = new SubscriptionService($deviceRepositoryInstance);

        try{
            if($subscriptionService->isSubscribed($token)){
                $apiResponseFactoryInstance = new APIResponseFactory(
                    APIResponseFactory::SUBSCRIPTION_PRESENT,
                    'This device is still subscribed.',
                    'success'
                );
            }else{
                $apiResponseFactoryInstance = new APIResponseFactory(
                    APIResponseFactory::SUBSCRIPTION_NOT_PRESENT,
                    'This device is not subscribed.',
                    'error'
                );
            }
        }catch (\Exception){
            $apiResponseFactoryInstance = new APIResponseFactory(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'A server side error has been occurred.',
                'error'
            );

            return $apiResponseFactoryInstance->generateJsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $apiResponseFactoryInstance->generateJsonResponse(Response::HTTP_OK);
    }
}
