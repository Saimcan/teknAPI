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

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private string $details;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column]
    private ?bool $isPurchaseSuccess = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $expireDate = null;

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

    public function getDetails(): string
    {
        return $this->details;
    }

    public function setDetails($details): self
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

    public function getExpireDate(): ?\DateTimeInterface
    {
        return $this->expireDate;
    }

    public function setExpireDate(?\DateTimeInterface $expireDate): self
    {
        $this->expireDate = $expireDate;

        return $this;
    }
}
