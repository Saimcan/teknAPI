<?php

namespace App\Service\API;

use App\Entity\Device;
use App\Entity\Purchase;
use App\Repository\DeviceRepository;
use App\Repository\PurchaseRepository;

class PurchaseService
{
    private PurchaseRepository $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function purchase(Device $device, array $details): void
    {
        $purchase = new Purchase();
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $details["expire-date"]);
        $purchase->setUid($device)
            ->setDetails('')
            ->setDateTime(new \DateTime())
            ->setIsPurchaseSuccess($details["status"])
            ->setExpireDate($dateTime);

        $this->purchaseRepository->save($purchase, true);
    }
}
