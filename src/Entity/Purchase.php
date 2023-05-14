<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Device $uid = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $details = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column]
    private ?bool $isPurchaseSuccess = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?Device
    {
        return $this->uid;
    }

    public function setUid(?Device $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function setDetails(?array $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function isIsPurchaseSuccess(): ?bool
    {
        return $this->isPurchaseSuccess;
    }

    public function setIsPurchaseSuccess(bool $isPurchaseSuccess): self
    {
        $this->isPurchaseSuccess = $isPurchaseSuccess;

        return $this;
    }
}
