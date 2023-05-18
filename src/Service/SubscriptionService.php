<?php

namespace App\Service;

use App\Entity\Device;
use App\Repository\DeviceRepository;

class SubscriptionService
{
    private DeviceRepository $deviceRepository;
    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function isSubscribed(string $clientToken): bool
    {
        /**
         * @var Device $device
         */
        $device = $this->deviceRepository->getDeviceByClientToken($clientToken);
        if(!is_null($device) && $clientToken == $device->getClientToken()){
            return true;
        }else{
            return false;
        }
    }
}
