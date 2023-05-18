<?php

namespace App\Service;

use App\Entity\Device;
use App\Repository\DeviceRepository;

class RegistrationService
{
    private DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function checkRegistration(int $uid): bool
    {
        /**
         * @var Device $device
         */
        $device = $this->deviceRepository->getDeviceByUid($uid);
        if(!is_null($device) && $device->getClientToken()){
            return true;
        }else{
            return false;
        }
    }

    public function checkRegistrationExpiration(int $uid): bool
    {
        return $this->deviceRepository->checkRegistrationExpiration($uid);
    }
}
