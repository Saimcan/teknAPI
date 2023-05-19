<?php

namespace App\Controller\API\v1;

use App\Entity\Device;
use App\Factory\APIResponseFactory;
use App\Repository\DeviceRepository;
use App\Repository\LanguageRepository;
use App\Service\API\RegistrationService;
use App\Service\API\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/register', name: 'api_register', methods: 'POST')]
    public function register(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        //validation check must be implemented here later on using symfony form builder.
        //it is not safe to take the data directly into db.
        $jsonData = json_decode($request->getContent(), true);

        $deviceRepositoryInstance = new DeviceRepository($doctrine);
        $registrationServiceInstance = new RegistrationService($deviceRepositoryInstance);

        try{
            if(!$registrationServiceInstance->checkRegistration($jsonData['uid'])){
                $device = new Device();
                $tokenServiceInstance = new TokenService();
                $now = new \DateTime();

                //instead of converting input data to object code below, I could have applied a DTO approach here.
                $langRepoInstance = new LanguageRepository($doctrine);
                $language = $langRepoInstance->findOneBy(['shortName' => $jsonData['language']]);

                $device->setUid($jsonData['uid'])
                    ->setAppId($jsonData['appId'])
                    ->setLanguage($language)
                    ->setClientToken($tokenServiceInstance->generateToken($jsonData['uid']))
                    ->setOperatingSystem($jsonData['os'])
                    ->setClientTokenExpirationDateTime($now->add(new \DateInterval('P90D')));

                $deviceRepositoryInstance->save($device, true);

                $apiResponseFactoryInstance = new APIResponseFactory(
                    APIResponseFactory::REGISTRATION_SUCCESS,
                    'Successfully registered device having uid: '. $device->getUid() .'.',
                    'success'
                );
            }else{
                //return json response already registered
                $apiResponseFactoryInstance = new APIResponseFactory(
                    APIResponseFactory::REGISTRATION_FAILED,
                    'This device was already registered.',
                    'error'
                );
            }
            return $apiResponseFactoryInstance->generateJsonResponse(Response::HTTP_OK);
        }catch (\Exception){
            $apiResponseFactoryInstance = new APIResponseFactory(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'A server side error has been occurred.',
                'error'
            );

            return $apiResponseFactoryInstance->generateJsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
