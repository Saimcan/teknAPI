<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $uid = null;

    #[ORM\Column]
    private ?int $appId = null;

    #[ORM\ManyToOne(inversedBy: 'devices')]
    private ?Language $language = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clientToken = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $clientTokenExpirationDateTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $operatingSystem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function setUid(int $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getAppId(): ?int
    {
        return $this->appId;
    }

    public function setAppId(int $appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getClientToken(): ?string
    {
        return $this->clientToken;
    }

    public function setClientToken(?string $clientToken): self
    {
        $this->clientToken = $clientToken;

        return $this;
    }

    public function getClientTokenExpirationDateTime(): ?\DateTimeInterface
    {
        return $this->clientTokenExpirationDateTime;
    }

    public function setClientTokenExpirationDateTime(?\DateTimeInterface $clientTokenExpirationDateTime): self
    {
        $this->clientTokenExpirationDateTime = $clientTokenExpirationDateTime;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(?string $operatingSystem): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }
}
