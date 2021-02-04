<?php

namespace App\Entity;

use App\Repository\FundraisingCardRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Entity(repositoryClass=FundraisingCardRepository::class)
 */
class FundraisingCard
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sourceId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sourceName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sourceUrl;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $eligibility;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $funderName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fundingAmount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $applicationEndDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $applicationUrl;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSourceId(): ?string
    {
        return $this->sourceId;
    }

    public function setSourceId(?string $sourceId): self
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSourceName(): ?string
    {
        return $this->sourceName;
    }

    public function setSourceName(?string $sourceName): self
    {
        $this->sourceName = $sourceName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getSourceUrl(): ?string
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl(?string $sourceUrl): self
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    public function getEligibility(): ?string
    {
        return $this->eligibility;
    }

    public function setEligibility(?string $eligibility): self
    {
        $this->eligibility = $eligibility;

        return $this;
    }

    public function getFunderName(): ?string
    {
        return $this->funderName;
    }

    public function setFunderName(?string $funderName): self
    {
        $this->funderName = $funderName;

        return $this;
    }

    public function getFundingAmount(): ?string
    {
        return $this->fundingAmount;
    }

    public function setFundingAmount(?string $fundingAmount): self
    {
        $this->fundingAmount = $fundingAmount;

        return $this;
    }

    public function getApplicationEndDate(): ?\DateTimeInterface
    {
        return $this->applicationEndDate;
    }

    public function setApplicationEndDate(?\DateTimeInterface $applicationEndDate): self
    {
        $this->applicationEndDate = $applicationEndDate;

        return $this;
    }

    public function getApplicationUrl(): ?string
    {
        return $this->applicationUrl;
    }

    public function setApplicationUrl(?string $applicationUrl): self
    {
        $this->applicationUrl = $applicationUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
