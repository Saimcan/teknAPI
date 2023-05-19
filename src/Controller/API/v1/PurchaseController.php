<?php

namespace App\Controller\API\v1;

use App\Factory\APIResponseFactory;
use App\Repository\DeviceRepository;
use App\Repository\PurchaseRepository;
use App\Service\API\PurchaseService;
use App\Service\MockAPI\IosService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PurchaseController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/purchase', name: 'api_purchase')]
    public function purchase(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        $iosServiceInstance = new IosService();
        $result = $iosServiceInstance->purchase($payload);

        $deviceRepositoryInstance = new DeviceRepository($doctrine);
        $purchaseRepositoryInstance = new PurchaseRepository($doctrine);
        //check if device present
        $device = $deviceRepositoryInstance->getDeviceByClientToken($payload["clientToken"]);
        $purchaseServiceInstance = new PurchaseService($purchaseRepositoryInstance);

        if(!is_null($device)){
            $purchaseServiceInstance->purchase($device, json_decode($result, true));
            return new JsonResponse(
                $result,
                Response::HTTP_OK,
                [],
                true
            );
        }else{
            $apiResponseFactoryInstance = new APIResponseFactory(
                APIResponseFactory::UNREGISTERED_DEVICE,
                'Device hasn\'t been registered.',
                'error'
            );

            return $apiResponseFactoryInstance->generateJsonResponse(Response::HTTP_OK);
        }
    }
}
