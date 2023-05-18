<?php

namespace App\Service;

use App\Entity\Device;
use App\Repository\DeviceRepository;

class RegistrationService
{
    private Device $device;
    private DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function register(Device $device)
    {
        $this->device = $device;
    }

    public function checkRegistration(int $uid): bool
    {
        return $this->deviceRepository->checkRegistration($uid);
    }

    public function checkRegistrationExpiration(int $uid): bool
    {
        return $this->deviceRepository->checkRegistrationExpiration($uid);
    }

    public function generateClientToken()
    {

    }

    public function regenerateClientToken()
    {

    }
}
