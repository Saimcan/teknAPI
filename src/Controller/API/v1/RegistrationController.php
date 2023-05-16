<?php

namespace App\Controller\API\v1;

use App\Entity\Device;
use App\Repository\DeviceRepository;
use App\Service\RegistrationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registerIndex', name: 'api_register_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RegistrationController.php',
        ]);
    }

    #[Route('/register', name: 'api_register', methods: 'POST')]
    public function register(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        //validation check might be implemented here later on using form builder.
        $jsonData = json_decode($request->getContent(), true);

        $deviceRepositoryInstance = new DeviceRepository($doctrine);
        $registrationServiceInstance = new RegistrationService($deviceRepositoryInstance);

        $registrationServiceInstance->checkRegistration($jsonData['uid']);

        if(!$registrationServiceInstance->checkRegistration($jsonData['uid'])){
            $device = new Device();
            $device->setUid($jsonData['uid'])
                ->setAppId($jsonData['appId'])
                ->setLanguage($jsonData['language'])
                ->setClientToken()
                ->setOperatingSystem()
                ->setClientTokenExpirationDateTime();

            $deviceRepositoryInstance->save($device);

            //return ok json http response
        }else{
            //return json response already registered
        }
    }
}
